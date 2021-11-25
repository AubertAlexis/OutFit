<?php
declare(strict_types=1);

namespace App\Controller\UI\Shop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{

    /**
     * @Route("/boutique", name="ui_shop_index")
     */
    public function index(): Response
    {
        return $this->render('ui/shop/index.html.twig');
    }

}
