<?php
namespace App\Security;

use App\Entity\User;

/**
 * Interface JwtUserInterface
 */
interface JwtUserInterface
{
    /**
     * @return User
     */
    public function get(): User;
}