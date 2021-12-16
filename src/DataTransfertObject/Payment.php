<?php
declare(strict_types=1);

namespace App\DataTransfertObject;

class Payment
{
    private ?string $token;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): Payment
    {
        $this->token = $token;
        return $this;
    }
}
