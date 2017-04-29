<?php

namespace Blade\Auth;

use Blade\Auth\AuthenticatableTrait;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Blade\Auth\Authenticatable as IAuthenticatable;


class AuthenticatableUser extends BaseModel implements IAuthenticatable
{
    use AuthenticatableTrait;
}