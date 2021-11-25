<?php
declare(strict_types=1);

namespace App\Controller\UI\Shop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Checkout extends AbstractController
{

    /**
     * @Route("/boutique/paiement", name="ui_shop_checkout")
     */
    public function checkout(): Response
    {
        return $this->render('ui/shop/checkout.html.twig');
    }

}
