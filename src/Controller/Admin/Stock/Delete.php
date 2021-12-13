<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stock;


use App\Entity\Stock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    /**
     * @Route("/stock/delete/{id}", name="admin_stock_delete", methods={"POST"})
     * @param Stock $stock
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Stock $stock, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = (string) $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-stock', $submittedToken)) {
            $manager->remove($stock);
            $manager->flush();

            $this->addFlash('success', 'Le stock a bien été supprimé.');
            return $this->redirectToRoute('admin_stock_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_stock_index');
    }
}
