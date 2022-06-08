<?php


namespace App\Repositories\Classes;


use App\Models\User;
use App\Repositories\Contracts\UserEloquentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserEloquentRepository extends BaseEloquentRepository implements UserEloquentRepositoryInterface
{
    protected function model()
    {
        return User::class;
    }

    public function queryConnectionSuggestions(User $user): Model|Builder
    {
        return $this->model
            ->where('id', '!=', $user->id)
            ->whereDoesntHave('requests_received', function ($query) use ($user) {
                $query->where('initiator_id', $user->id);
            })
            ->whereDoesntHave('connections', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->inRandomOrder();
    }

    public function getPaginatedConnectionSuggestions(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->queryConnectionSuggestions($user)->paginate($perPage);
    }

    public function countConnectionSuggestions(User $user): int
    {
        return $this->queryConnectionSuggestions($user)->count();
    }

    public function queryUserConnections(User $user): Model|Builder
    {
        return $this->model
            ->whereHas('connections', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('connection_id', $user->id);
            });
    }

    public function getPaginatedUserConnections(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->queryUserConnections($user)->paginate($perPage);
    }

    public function countUserConnections(User $user): int
    {
        return $this->queryUserConnections($user)->count();
    }
}
