<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class RequestPolicy extends BasePolicy
{
    public Request $model;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Request;
    }

    public function update(User $user, Model $model): Response|bool
    {
        return $this->isActiveUser($user) && (
            $this->isOwner($user, $model) ||
            $this->isTarget($user, $model)
        );
    }

    public function isOwner(User $user, Request|Model $model): bool
    {
        return $model->initiator_id === $user->id;
    }

    public function isTarget(User $user, Request|Model $model): bool
    {
        return $model->target_id = $user->id;
    }
}
