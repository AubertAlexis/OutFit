<?php
declare(strict_types=1);

namespace App\Controller\UI\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Personal extends AbstractController
{

    /**
     * @Route("/mon-compte/informations", name="ui_account_personal")
     */
    public function personal(): Response
    {
        return $this->render('ui/account/personal.html.twig');
    }

}
