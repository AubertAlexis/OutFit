<?php
declare(strict_types=1);

namespace App\Controller\Admin\Color;


use App\Entity\Color;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    /**
     * @Route("/color/delete/{id}", name="admin_color_delete", methods={"POST"})
     * @param Color $color
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Color $color, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = (string) $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-color', $submittedToken)) {
            $manager->remove($color);
            $manager->flush();

            $this->addFlash('success', 'La couleur a bien été supprimé.');
            return $this->redirectToRoute('admin_color_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_color_index');
    }
}
