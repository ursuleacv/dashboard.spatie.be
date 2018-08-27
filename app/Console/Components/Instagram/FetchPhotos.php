<?php

namespace App\Console\Components\Instagram;

use App\Events\Instagram\PhotoFetched;
use App\Services\InstagramHistory\InstagramHistory;
use Illuminate\Console\Command;
use App\Services\Instagram\InstagramApi;
use Spatie\Valuestore\Valuestore;

class FetchPhotos extends Command
{
    protected $signature = 'dashboard:fetch-instagram-photos';

    protected $description = 'Fetch Instagram photos';

    public function handle(InstagramApi $instagram)
    {
        $lastBroadcastedId = InstagramHistory::getHighestId();

       $instagram
            ->getAll()
            ->filter(function (array $photo) use ($lastBroadcastedId) {
                return $photo['id'] > $lastBroadcastedId;
            })
            ->sortBy('id')
            ->each(function (array $photo) {
                event(new PhotoFetched($photo));
            });
    }
}
