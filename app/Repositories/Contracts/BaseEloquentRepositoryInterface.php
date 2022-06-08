<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Builder;

interface BaseEloquentRepositoryInterface
{
    /**
     * Begin querying the model.
     *
     * @return Builder
     */
    public function query(): Builder;
}
