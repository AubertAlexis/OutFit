<?php
declare(strict_types=1);

namespace App\Controller\Admin\Delivery;


use App\Entity\Delivery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    /**
     * @Route("/delivery/delete/{id}", name="admin_delivery_delete", methods={"POST"})
     * @param Delivery $delivery
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Delivery $delivery, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = (string) $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-delivery', $submittedToken)) {
            $manager->remove($delivery);
            $manager->flush();

            $this->addFlash('success', 'La méthode de paiement a bien été supprimé.');
            return $this->redirectToRoute('admin_delivery_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_delivery_index');
    }
}
