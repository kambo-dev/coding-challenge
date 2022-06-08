<?php


namespace App\Repositories\Classes;


use App\Models\Request;
use App\Models\User;
use App\Repositories\Contracts\RequestsEloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class RequestsEloquentRepository extends BaseEloquentRepository implements RequestsEloquentRepositoryInterface
{
    public function model()
    {
        return Request::class;
    }

    public function queryUserRequests(User $user, string $status = null): Model|Builder
    {
        return $this->model
            ->with(['target', 'initiator'])
            ->where(function ($query) use ($user) {
                $query->where('initiator_id', $user->id)
                    ->orWhere('target_id', $user->id);
            })
            ->when(isset($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('created_at');
    }

    public function getPaginatedUserRequests(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->queryUserRequests($user)->paginate($perPage);
    }

    public function getPaginatedUserRequestsByStatus(User $user, string $status = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->queryUserRequests($user, $status)->paginate($perPage);
    }

    public function queryUserSentRequests(User $user, string $status = null): Model|Builder
    {
        return $this->model
            ->with(['target', 'initiator'])
            ->where(function ($query) use ($user) {
                $query->where('initiator_id', $user->id);
            })
            ->when(isset($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('created_at');
    }

    public function queryUserReceivedRequests(User $user, string $status = null): Model|Builder
    {
        return $this->model
            ->with(['target', 'initiator'])
            ->where(function ($query) use ($user) {
                $query->where('target_id', $user->id);
            })
            ->when(isset($status), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('created_at');
    }

    public function getPaginatedUserSentRequests(User $user, string $status = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->queryUserSentRequests($user, $status)->paginate($perPage);
    }

    public function countUserSentRequests(User $user, string $status = null): int
    {
        return $this->queryUserSentRequests($user, $status)->count();
    }

    public function getPaginatedUserReceivedRequests(User $user, string $status = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->queryUserReceivedRequests($user, $status)->paginate($perPage);
    }

    public function countUserReceivedRequests(User $user, string $status = null): int
    {
        return $this->queryUserReceivedRequests($user, $status)->count();
    }
}
