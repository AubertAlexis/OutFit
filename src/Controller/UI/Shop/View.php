<?php
declare(strict_types=1);

namespace App\Controller\UI\Shop;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class View extends AbstractController
{

    /**
     * @Route("/boutique/details/{id}", name="ui_shop_view")
     * @param Product $product
     * @return Response
     */
    public function view(Product $product): Response
    {
        return $this->render('ui/shop/view.html.twig', compact('product'));
    }

}
