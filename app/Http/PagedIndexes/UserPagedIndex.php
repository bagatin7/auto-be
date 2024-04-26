<?php

namespace App\Http\PagedIndexes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use M3Team\PagedIndex\DatabasePagedIndex;

class UserPagedIndex extends DatabasePagedIndex
{
    public static function all(): UserPagedIndex
    {
        return new UserPagedIndex(User::query());
    }

    protected function sort(): EloquentBuilder|QueryBuilder
    {
        return $this->builder->orderBy($this->sortColumn, $this->sortDirection);
    }

    protected function filter(): EloquentBuilder|QueryBuilder
    {
        return $this->builder;
    }
}
