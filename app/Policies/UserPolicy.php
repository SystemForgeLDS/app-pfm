<?php

namespace App\Policies;

use App\Constants\UserRoles;
use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER);
    }

    // editar clientes (sócio e consultor)
    public function update(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER);
    }

    public function delete(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER);
    }

    //quem vê a coluna "ações" (talvez seja mudado)
    public function action(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER);
    }

    public function censored(User $user): bool
    {
        return true;
    }
}
