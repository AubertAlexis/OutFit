<?php
declare(strict_types=1);

namespace App\Controller\UI\Shop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class View extends AbstractController
{

    /**
     * @Route("/boutique/details", name="ui_shop_view")
     */
    public function view(): Response
    {
        return $this->render('ui/shop/view.html.twig');
    }

}
