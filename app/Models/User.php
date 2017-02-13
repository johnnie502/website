<?php

namespace App\Models;

use Junaidnasir\Larainvite\InviteTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait, Traits\UserOperation, softDeletes, InviteTrait;

    protected $dates = ['deleted_at'];
    protected $fillable = ['username', 'email', 'password'];
}
