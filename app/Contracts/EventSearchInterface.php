<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

interface EventSearchInterface extends Jsonable, Arrayable
{
    public function getUserEventsByDate($userId, $fromDate, $toDate, $columns = ['*']);
}
