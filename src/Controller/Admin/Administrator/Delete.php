<?php
declare(strict_types=1);

namespace App\Controller\Admin\Administrator;


use App\Entity\Administrator;
use App\Entity\User;
use App\Form\AdministratorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    /**
     * @Route("/administrator/delete/{id}", name="admin_administrator_delete", methods={"POST"})
     * @param Administrator $administrator
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Administrator $administrator, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-administrator', $submittedToken)) {
            $manager->remove($administrator);
            $manager->flush();

            $this->addFlash('success', 'L\'administrateur a bien été supprimé.');
            return $this->redirectToRoute('admin_administrator_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_administrator_index');
    }
}
