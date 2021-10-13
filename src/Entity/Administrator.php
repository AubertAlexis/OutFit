<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AdministratorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdministratorRepository::class)
 */
class Administrator extends User
{
    public function __construct()
    {
        parent::__construct();

        $this->setRoles([User::ROLE_ADMINISTRATOR]);
    }
}
