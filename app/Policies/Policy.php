<?php

namespace App\Policies;

use App\Models\user;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before(User $user, $ability)
	{
	    //
	}
}
