<?php
declare(strict_types=1);

namespace App\Controller\UI\Shop;

use _PHPStan_76800bfb5\Nette\Neon\Exception;
use App\DataTransfertObject\Payment;
use App\Entity\Order\Order;
use App\Form\StripeType;
use App\Repository\CustomerRepository;
use App\Repository\Order\OrderRepository;
use App\Services\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Exception\ApiErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Checkout extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private StripeService $stripeService;

    /**
     * @param EntityManagerInterface $entityManager
     * @param StripeService $stripeService
     */
    public function __construct(EntityManagerInterface $entityManager, StripeService $stripeService)
    {
        $this->entityManager = $entityManager;
        $this->stripeService = $stripeService;
    }


    /**
     * @Route("/boutique/paiement", name="ui_shop_checkout")
     * @param Request $request
     * @param CustomerRepository $customerRepository
     * @param OrderRepository $orderRepository
     * @return Response
     * @throws Exception
     * @throws ApiErrorException
     */
    public function checkout(
        Request $request,
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository
    ): Response
    {
        $customer = $customerRepository->findOneBy([]);
        $paymentObject = new Payment();

        $form = $this->createForm(StripeType::class, $paymentObject)->handleRequest($request);

        $order = $orderRepository->findOneBy([
            'customer' => $customer,
            'state' => Order::CART
        ]);

        if (!$order) return $this->redirectToRoute('ui_shop_checkout');

        // Pas encore client
        if ($form->isSubmitted() && $form->isValid()) {
            $token = $paymentObject->getToken();

            if (!$token) return $this->redirectToRoute('ui_shop_checkout');

            $customerStripe = $this->stripeService->createCustomer($customer->getUser()->getEmail(), $customer->getFullName());
            $customerStripeId = $customerStripe->id;

            $customer->setStripeId($customerStripeId);
            $this->entityManager->flush();

            $card = $this->stripeService->createCard($customerStripeId, $token);

            if (!$card) throw new Exception('Aucun moyen de paiement défini.');

            $this->payOrder($order, $customerStripeId);

            return $this->redirectToRoute('ui_home_index');

        }

        // Déjà client
        if ($customer->getStripeId() !== null) {
            $customerStripeId = $customer->getStripeId();

            $customerStripe = $this->stripeService->getCustomer($customerStripeId);

            if (!$customerStripe) {
                $customer->setStripeId(null);
                $this->entityManager->flush();
                return $this->redirectToRoute('ui_shop_index');
            }

            $this->payOrder($order, $customerStripeId);

            return $this->redirectToRoute('ui_home_index');

        }

        return $this->render('ui/shop/checkout.html.twig', [
            'form' => $form->createView(),
            'stripe_pk' => $this->getParameter('stripe_pk')
        ]);
    }

    private function payOrder(Order $order, string $customer)
    {
        $payment = $this->stripeService->pay($order->getTotal(true), $customer);

        if ($payment->status === 'succeeded') {
            $order->setState(Order::SUCCESS);
            $order->setStripeId($payment->id);
        } else {
            $order->setState(Order::REFUSED);
        }

        $this->entityManager->flush();
    }
}
