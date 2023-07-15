<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class CarPolicy
{
    /**
     * Determine whether the user can view any models.
     */


    public function destroy(User $user, Car $car)
    {
        $admin = $user->admin;
        if ($admin) {
            return response()->json(['message' => 'Car deleted'], ResponseAlias::HTTP_OK);
        }

        return response()->json(['message' => 'Unauthorized'], ResponseAlias::HTTP_UNAUTHORIZED);
    }


}
