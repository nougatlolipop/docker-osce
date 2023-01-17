<?php

namespace App\Libraries;

use MDHearing\AspNetCore\Identity\PasswordHasher as MDHearing;

class AspNetCore
{
    public function __construct()
    {
        $this->hasher = new MDHearing();
    }

    public function verifyAsp($passFromDb, $passFromForm)
    {
        $result = $this->hasher->verifyHashedPassword($passFromDb, $passFromForm);
        return $result;
    }

    public function hashAsp($string)
    {
        $hashedPassword = $this->hasher->hashPassword($string);
        return $hashedPassword;
    }
}
