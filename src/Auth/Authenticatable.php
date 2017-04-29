<?php

namespace Blade\Auth;

interface Authenticatable
{

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getIdName();


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getIdentifier();


    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getPassword();


    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getToken();


    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setToken($value);


    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getTokenName();


}
