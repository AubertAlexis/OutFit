<?php
declare(strict_types=1);

namespace App\Controller\Admin\Discount;


use App\Entity\Discount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    /**
     * @Route("/discount/delete/{id}", name="admin_discount_delete", methods={"POST"})
     * @param Discount $discount
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Discount $discount, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = (string) $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-discount', $submittedToken)) {
            $manager->remove($discount);
            $manager->flush();

            $this->addFlash('success', 'La réduction a bien été supprimé.');
            return $this->redirectToRoute('admin_discount_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_discount_index');
    }
}
