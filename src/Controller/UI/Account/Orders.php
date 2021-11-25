<?php
declare(strict_types=1);

namespace App\Controller\UI\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Orders extends AbstractController
{

    /**
     * @Route("/mon-compte/commandes", name="ui_account_orders")
     */
    public function orders(): Response
    {
        return $this->render('ui/account/orders.html.twig');
    }

}
