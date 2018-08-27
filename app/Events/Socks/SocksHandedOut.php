<?php

namespace App\Events\Socks;

use App\Events\DashboardEvent;

class SocksHandedOut extends DashboardEvent
{
    /** @var int */
    public $socksHandedOut;

    public function __construct(int $socksHandedOut)
    {
        $this->socksHandedOut = $socksHandedOut;
    }
}
