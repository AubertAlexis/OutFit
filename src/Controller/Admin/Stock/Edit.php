<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stock;


use App\Entity\Stock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\StockType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    /**
     * @Route("/stock/edit/{id}", name="admin_stock_edit", methods={"GET", "POST"})
     * @param Stock $stock
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Stock $stock, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(StockType::class, $stock)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'La couleur a bien été modifié.');
            return $this->redirectToRoute('admin_stock_index');
        }

        return $this->render('admin/stock/edit.html.twig', [
            'form' => $form->createView(),
            'stock' => $stock
        ]);
    }
}
