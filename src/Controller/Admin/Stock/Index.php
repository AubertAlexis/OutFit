<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stock;


use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    /**
     * @Route("/stock", name="admin_stock_index", methods={"GET"})
     * @param StockRepository $stockRepository
     * @return Response
     */
    public function index(StockRepository $stockRepository): Response
    {
        return $this->render('admin/stock/index.html.twig', [
            'datatable' => true,
            'stocks' => $stockRepository->findAll()
        ]);
    }
}
