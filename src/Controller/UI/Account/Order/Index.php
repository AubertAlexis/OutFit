<?php
declare(strict_types=1);

namespace App\Controller\UI\Account\Order;

use App\Repository\CustomerRepository;
use App\Repository\Order\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{

    /**
     * @Route("/mon-compte/commandes", name="ui_account_order_index")
     * @param OrderRepository $orderRepository
     * @param CustomerRepository $customerRepository
     * @return Response
     */
    public function index(OrderRepository $orderRepository, CustomerRepository $customerRepository): Response
    {
        $customer = $customerRepository->findOneBy([]);
        return $this->render('ui/account/order/index.html.twig', [
            'orders' => $orderRepository->findBy(['customer' => $customer])
        ]);
    }

}
