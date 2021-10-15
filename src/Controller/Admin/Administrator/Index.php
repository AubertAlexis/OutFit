<?php
declare(strict_types=1);

namespace App\Controller\Admin\Administrator;


use App\Repository\AdministratorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    /**
     * @Route("/administrator", name="admin_administrator_index", methods={"GET"})
     * @param AdministratorRepository $administratorRepository
     * @return Response
     */
    public function index(AdministratorRepository $administratorRepository): Response
    {
        return $this->render('admin/administrator/index.html.twig', [
            'datatable' => true,
            'administrators' => $administratorRepository->findAll()
        ]);
    }
}
