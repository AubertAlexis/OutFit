<?php
declare(strict_types=1);

namespace App\Controller\Admin\Delivery;


use App\Repository\DeliveryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    /**
     * @Route("/delivery", name="admin_delivery_index", methods={"GET"})
     * @param DeliveryRepository $deliveryRepository
     * @return Response
     */
    public function index(DeliveryRepository $deliveryRepository): Response
    {
        return $this->render('admin/delivery/index.html.twig', [
            'datatable' => true,
            'deliveries' => $deliveryRepository->findAll()
        ]);
    }
}
