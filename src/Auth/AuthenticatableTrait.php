<?php

namespace Blade\Auth;

trait AuthenticatableTrait
{
    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = 'remember_token';


    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getIdName()
    {
        return $this->getKeyName();
    }


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getKey();
    }


    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getToken()
    {
        if (! empty($this->getTokenName())) {
            return $this->{$this->getTokenName()};
        }
    }


    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        if (! empty($this->getTokenName())) {
            $this->{$this->getTokenName()} = $value;
        }
    }


    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }


}