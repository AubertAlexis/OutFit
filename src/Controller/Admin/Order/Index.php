<?php
declare(strict_types=1);

namespace App\Controller\Admin\Order;


use App\Entity\Order\Order;
use App\Repository\CustomerRepository;
use App\Repository\Order\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    /**
     * @Route("/order", name="admin_order_index", methods={"GET"})
     * @param OrderRepository $orderRepository
     * @param CustomerRepository $customerRepository
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(
        OrderRepository $orderRepository,
        CustomerRepository $customerRepository,
        ProductRepository $productRepository,
        EntityManagerInterface $em
    ): Response
    {
        $customer = $customerRepository->findOneBy([]);
        $product = $productRepository->findOneBy([]);

        $order = new Order();
        $order->setState(Order::CART)
            ->setNumber("3")
            ->setCustomer($customer)
            ->addProduct($product);

        $em->persist($order);
        $em->flush();

        return $this->render('admin/Order/index.html.twig', [
            'datatable' => true,
            'orders' => $orderRepository->findAll()
        ]);
    }
}
