<?php
declare(strict_types=1);

namespace App\Controller\Admin\Discount;


use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    /**
     * @Route("/discount", name="admin_discount_index", methods={"GET"})
     * @param DiscountRepository $discountRepository
     * @return Response
     */
    public function index(DiscountRepository $discountRepository): Response
    {
        return $this->render('admin/discount/index.html.twig', [
            'datatable' => true,
            'discounts' => $discountRepository->findAll()
        ]);
    }
}
