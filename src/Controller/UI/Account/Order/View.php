<?php
declare(strict_types=1);

namespace App\Controller\UI\Account\Order;

use App\Repository\CustomerRepository;
use App\Repository\Order\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class View extends AbstractController
{

    /**
     * @Route("/mon-compte/commandes/{id}", name="ui_account_order_view")
     * @param OrderRepository $orderRepository
     * @return Response
     */
    public function view(OrderRepository $orderRepository, string $id): Response
    {
        return $this->render('ui/account/order/view.html.twig', [
            'order' => $orderRepository->find($id)
        ]);
    }

}
