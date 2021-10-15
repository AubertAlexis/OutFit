<?php
declare(strict_types=1);

namespace App\Controller\Admin\Size;


use App\Repository\SizeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    /**
     * @Route("/size", name="admin_size_index", methods={"GET"})
     * @param SizeRepository $sizeRepository
     * @return Response
     */
    public function index(SizeRepository $sizeRepository): Response
    {
        return $this->render('admin/size/index.html.twig', [
            'datatable' => true,
            'sizes' => $sizeRepository->findAll()
        ]);

    }
}
