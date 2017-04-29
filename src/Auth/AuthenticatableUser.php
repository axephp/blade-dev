<?php

namespace Blade\Auth;

use Blade\Auth\AuthenticatableTrait;
use Blade\Database\Model;
use Blade\Auth\Authenticatable as IAuthenticatable;


class AuthenticatableUser extends Model implements IAuthenticatable
{
    use AuthenticatableTrait;
}