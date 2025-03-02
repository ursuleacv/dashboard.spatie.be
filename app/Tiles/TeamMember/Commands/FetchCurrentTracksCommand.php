<?php

namespace App\Tiles\TeamMember\Commands;

use Exception;
use Illuminate\Console\Command;
use Spatie\NowPlaying\NowPlaying;
use App\Tiles\TeamMember\TeamMemberStore;

class FetchCurrentTracksCommand extends Command
{
    protected $signature = 'dashboard:fetch-current-tracks';

    protected $description = 'Fetch the currently playing track from lastFm';

    protected $lastFmUsers = [
        'murze' => 'freek',
        'willemvb' => 'william',
    ];

    public function handle()
    {
        $this->info('Fetching current tracks');

        $lastFm = new NowPlaying(config('services.last-fm.api_key'));

        collect($this->lastFmUsers)
            ->each(function (string $teamMemberName, string $lastFmUserName) use ($lastFm) {
                $teamMemberStore = TeamMemberStore::find($teamMemberName);

                try {
                    $currentTrack = $lastFm->getTrackInfo($lastFmUserName);

                    $currentTrack
                        ? $teamMemberStore->setNowPlaying($currentTrack)
                        : $teamMemberStore->setNothingPlaying();
                } catch (Exception $exception) {
                    report($exception);
                }
            });

        $this->info('All done!');
    }
}
