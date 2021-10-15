<?php
declare(strict_types=1);

namespace App\Controller\Admin\Color;


use App\Repository\ColorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    /**
     * @Route("/color", name="admin_color_index", methods={"GET"})
     * @param ColorRepository $colorRepository
     * @return Response
     */
    public function index(ColorRepository $colorRepository): Response
    {
        return $this->render('admin/color/index.html.twig', [
            'datatable' => true,
            'colors' => $colorRepository->findAll()
        ]);
    }
}
