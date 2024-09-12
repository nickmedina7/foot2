<?php

namespace App\Policies;

use App\Models\User;  // Cambia App\User a App\Models\User
use App\Patrones\Rol;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $authUser, $ability)
    {
        if ($authUser->rol === Rol::Administrador) {
            return true;
        }
    }

    public function show(User $authUser, User $user)
    {
        return $authUser->id === $user->id;
    }
}
