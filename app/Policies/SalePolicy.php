<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;  // Cambia App\User a App\Models\User
use App\Patrones\Rol;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalePolicy
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

    public function destroy(User $authUser, Sale $sale)
    {
        return $authUser->id === $sale->users_id;
    }
}
