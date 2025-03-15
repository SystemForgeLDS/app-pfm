<?php

namespace App\Policies;

use App\Constants\UserRoles;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
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

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER || 
                $user->type == UserRoles::FINANCIER);
    }

    // editar clientes (sócio e consultor)
    public function update(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER || 
                $user->type == UserRoles::FINANCIER);
    }

    public function delete(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER || 
                $user->type == UserRoles::FINANCIER);
    }

    //quem vê a coluna "ações" (talvez seja mudado)
    public function action(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER || 
                $user->type == UserRoles::FINANCIER);
    }

    public function censored(User $user): bool
    {
        return true;
    }
}
