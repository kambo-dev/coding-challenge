<?php


namespace App\Repositories\Contracts;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RequestsEloquentRepositoryInterface extends BaseEloquentRepositoryInterface
{
    /**
     * Get connection requests where $user is initiator or target as query
     *
     * @param User $user
     * @param string|null $status
     * @return Model|Builder
     */
    public function queryUserRequests(User $user, string $status = null): Model|Builder;

    /**
     * Get connection requests where $user is initiator or target as paginated resource
     *
     * @param User $user
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedUserRequests(User $user, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get connection requests filtered by $status where $user is initiator or target as paginated resource
     *
     * @param User $user
     * @param string $status - in: RequestStatuses enum
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedUserRequestsByStatus(User $user, string $status, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get connection requests where $user is initiator as query
     *
     * @param User $user
     * @param string|null $status
     * @return Model|Builder
     */
    public function queryUserSentRequests(User $user, string $status = null): Model|Builder;

    /**
     * Get connection requests where $user is target as query
     *
     * @param User $user
     * @param string|null $status
     * @return Model|Builder
     */
    public function queryUserReceivedRequests(User $user, string $status = null): Model|Builder;

    /**
     * Get connection requests where $user is initiator as paginated resource
     *
     * @param User $user
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedUserSentRequests(User $user, string $status = null, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get connection requests where $user is initiator as count
     *
     * @param User $user
     * @param string|null $status
     * @return int
     */
    public function countUserSentRequests(User $user, string $status = null): int;

    /**
     * Get connection requests where $user is target as paginated resource
     *
     * @param User $user
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedUserReceivedRequests(User $user, string $status = null, int $perPage = 10): LengthAwarePaginator;

    /**
     * Get connection requests where $user is target as count
     *
     * @param User $user
     * @param string|null $status
     * @return int
     */
    public function countUserReceivedRequests(User $user, string $status = null): int;
}
