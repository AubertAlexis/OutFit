<?php
declare(strict_types=1);

namespace App\Controller\UI\Shop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Cart extends AbstractController
{

    /**
     * @Route("/boutique/panier", name="ui_shop_cart")
     */
    public function cart(): Response
    {
        return $this->render('ui/shop/cart.html.twig');
    }

}
