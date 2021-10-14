<?php
declare(strict_types=1);

namespace App\Controller\UI\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{

    /**
     * @Route("", name="ui_home_index")
     */
    public function index(): Response
    {
        return $this->render('ui/home/index.html.twig');
    }

}
