<?php

namespace App\Http\PagedIndexes;

use App\Models\Record;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use M3Team\PagedIndex\DatabasePagedIndex;

class RecordPagedIndex extends DatabasePagedIndex
{
    public static function all()
    {
        return new RecordPagedIndex(Record::query());
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
