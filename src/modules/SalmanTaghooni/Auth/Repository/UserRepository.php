<?php

namespace SalmanTaghooni\Auth\Repository;

use App\Models\User;



class UserRepository
{
    public function firstOrCreate($request)
    {
        User::firstOrCreate(['phone_number' => $request['phone_number']]);
    }
}
