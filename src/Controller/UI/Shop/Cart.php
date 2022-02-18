<?php
declare(strict_types=1);

namespace App\Controller\UI\Shop;

use App\Entity\Delivery;
use App\Entity\Order\Line;
use App\Entity\Order\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Repository\DeliveryRepository;
use App\Repository\Order\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Cart extends AbstractController
{

    /**
     * @Route("/boutique/panier", name="ui_shop_cart")
     * @param OrderRepository $orderRepository
     * @param DeliveryRepository $deliveryRepository
     * @return Response
     */
    public function cart(
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository,
        DeliveryRepository $deliveryRepository
    ): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_CUSTOMER);

        /** @var User $user */
        $user = $this->getUser();
        $customer = $user->getCustomer();

        $deliveries = $deliveryRepository->findAll();

        $order = $orderRepository->findOneBy([
            'customer' => $customer,
            'state' => Order::CART
        ]);

        if (!$order) return $this->redirectToRoute('ui_shop_index');

        return $this->render('ui/shop/cart.html.twig', [
            'order' => $order,
            'total' => $order->getTotal(),
            'deliveries' => $deliveries
        ]);
    }


    /**
     * @Route("/boutique/panier/{type}/{id}", name="ui_shop_cart_handle", defaults={"type": "increase"}, priority="0")
     * @param string $type
     * @param Product $product
     * @param CustomerRepository $customerRepository
     * @param OrderRepository $orderRepository
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function handle(
        string $type,
        Product $product,
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager
    ): RedirectResponse
    {
        $customer = $customerRepository->findOneBy([]);

        $order = $orderRepository->findOneBy([
            'customer' => $customer,
            'state' => Order::CART
        ]);

        if (!$order) {
            $order = new Order();
            $order
                ->setNumber($customer->getId()->__toString())
                ->setState(Order::CART)
                ->setCustomer($customer)
            ;

            $entityManager->persist($order);
        }

        if ($type === 'increase') {
            $order->addProduct($product);
        } else {
            $order->decreaseProduct($product);
        }

        $entityManager->flush();

        return $this->redirectToRoute('ui_shop_cart');
    }

    /**
     * @Route("/boutique/panier/{id}/remove", name="ui_shop_cart_remove", priority="1")
     * @param Line $line
     * @param CustomerRepository $customerRepository
     * @param OrderRepository $orderRepository
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function remove(
        Line $line,
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager
    ): RedirectResponse
    {
        $customer = $customerRepository->findOneBy([]);

        $order = $orderRepository->findOneBy([
            'customer' => $customer,
            'state' => Order::CART
        ]);

        if (!$order) {
            return $this->redirectToRoute('ui_shop_cart');
        }

        if ($order->getLines()->contains($line)) {
            $entityManager->remove($line);
        }

        $entityManager->flush();

        return $this->redirectToRoute('ui_shop_cart');
    }

    /**
     * @Route("/boutique/panier/{id}/delivery", name="ui_shop_cart_delivery", priority="1")
     * @param Delivery $delivery
     * @param CustomerRepository $customerRepository
     * @param OrderRepository $orderRepository
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse
     */
    public function delivery(
        Delivery $delivery,
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager
    ): RedirectResponse
    {
        $customer = $customerRepository->findOneBy([]);

        $order = $orderRepository->findOneBy([
            'customer' => $customer,
            'state' => Order::CART
        ]);

        if (!$order) {
            return $this->redirectToRoute('ui_shop_cart');
        }

        $order->setDelivery($delivery);

        $entityManager->flush();

        return $this->redirectToRoute('ui_shop_cart');
    }

}
