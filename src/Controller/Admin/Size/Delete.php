<?php
declare(strict_types=1);

namespace App\Controller\Admin\Size;


use App\Entity\Size;
use App\Form\SizeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    /**
     * @Route("/size/delete/{id}", name="admin_size_delete", methods={"POST"})
     * @param Size $size
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Size $size, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = (string) $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-size', $submittedToken)) {
            $manager->remove($size);
            $manager->flush();

            $this->addFlash('success', 'La taille a bien été supprimé.');
            return $this->redirectToRoute('admin_size_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_size_index');
    }
}
