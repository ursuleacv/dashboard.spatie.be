<?php

namespace App\Events\Instagram;

use App\Events\DashboardEvent;

class PhotoFetched extends DashboardEvent
{
    /** @var array */
    public $photo;

    public function __construct(array $photo)
    {
        $this->photo = $photo;
    }
}
