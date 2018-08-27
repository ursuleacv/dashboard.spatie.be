<?php

namespace App\Console\Components\Socks;

use App\Events\Socks\SocksHandedOut;
use Illuminate\Console\Command;
use Spatie\Valuestore\Valuestore;

class IncrementSockCount extends Command
{
    protected $signature = 'dashboard:increment-sock-count {amount?}';

    protected $description = 'Sets the sock count';

    public function handle()
    {
        $valuestore = Valuestore::make(storage_path('app/socks.json'));

        $valuestore->increment('socksHandedOut', $this->argument('amount') ?? 1);

        event(new SocksHandedOut($valuestore->get('socksHandedOut')));
    }
}
