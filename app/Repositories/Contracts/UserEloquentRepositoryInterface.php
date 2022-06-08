<?php


namespace App\Repositories\Contracts;


use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UserEloquentRepositoryInterface extends BaseEloquentRepositoryInterface
{

    /**
     * Get connection suggestions for $user as query
     *
     * @param User $user
     * @return Model|Builder
     */
    public function queryConnectionSuggestions(User $user): Model|Builder;

    /**
     * Get connection suggestions as paginated resource
     *
     * @param User $user
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedConnectionSuggestions(User $user, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get connection suggestions as count
     *
     * @param User $user
     * @return int
     */
    public function countConnectionSuggestions(User $user): int;

    /**
     * Get current connections for $user as query
     *
     * @param User $user
     * @return Model|Builder
     */
    public function queryUserConnections(User $user): Model|Builder;

    /**
     * Get current connections for $user as paginated resource
     *
     * @param User $user
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedUserConnections(User $user, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get current connections for $user as count
     *
     * @param User $user
     * @return int
     */
    public function countUserConnections(User $user): int;
}
