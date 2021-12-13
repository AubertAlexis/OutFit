<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stock;


use App\Entity\Stock;
use App\Form\StockType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    /**
     * @Route("/stock/add", name="admin_stock_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $stock = new Stock();

        $form = $this->createForm(StockType::class, $stock)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($stock);
            $manager->flush();
            $this->addFlash('success', 'Le stock a bien été créé.');
            return $this->redirectToRoute('admin_stock_index');
        }

        return $this->render('admin/stock/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
