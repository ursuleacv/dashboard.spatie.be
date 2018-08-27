<?php

namespace App\Services\Instagram;

use Illuminate\Support\Collection;

interface InstagramApi
{
    public function getAll(): Collection;
}
