<?php

namespace App\Policies;

use App\Constants\UserRoles;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
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
    public function view(User $user, Client $client): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER || 
                $user->type == UserRoles::CONSULTANT);
    }

    // editar clientes (sócio e consultor)
    public function update(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER || 
                $user->type == UserRoles::CONSULTANT);
    }

    public function delete(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER || 
                $user->type == UserRoles::CONSULTANT);
    }

    //quem vê a coluna "ações" (talvez seja mudado)
    public function action(User $user): bool
    {
        return ($user->type == UserRoles::PARTNER || 
                $user->type == UserRoles::CONSULTANT);
    }

    public function censored(User $user): bool
    {
        return true;
    }

}
