<?php

namespace App\Console\Components\Socks;

use App\Events\Socks\SocksHandedOut;
use Illuminate\Console\Command;
use Spatie\Valuestore\Valuestore;

class SetSockCount extends Command
{
    protected $signature = 'dashboard:set-sock-count {count}';

    protected $description = 'Sets the sock count';

    public function handle()
    {
        $valuestore = Valuestore::make(storage_path('app/socks.json'));

        $valuestore->put('socksHandedOut', $this->argument('count') ?? 0);

        event(new SocksHandedOut($valuestore->get('socksHandedOut')));
    }
}
