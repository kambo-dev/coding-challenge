<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public abstract function __construct();

    /**
     * Determine whether the user can view any models.
     *
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $this->isActiveUser($user);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function view(User $user, Model $model): Response|bool
    {
        return $this->isActiveUser($user) && $this->isOwner($user, $model);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return $this->isActiveUser($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function update(User $user, Model $model): Response|bool
    {
        return $this->isActiveUser($user) && $this->isOwner($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function delete(User $user, Model $model): Response|bool
    {
        return $this->isActiveUser($user) && $this->isOwner($user, $model);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function restore(User $user, Model $model): Response|bool
    {
        return $this->isActiveUser($user) && $this->isOwner($user, $model);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Model $model
     * @return Response|bool
     */
    public function forceDelete(User $user, Model $model): Response|bool
    {
        return $this->isActiveUser($user) && $this->isOwner($user, $model);
    }

    public function isActiveUser(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function isOwner(User $user, Model $model): bool
    {
        return isset($model->user_id) && $user->id == $model->user_id;
    }
}
