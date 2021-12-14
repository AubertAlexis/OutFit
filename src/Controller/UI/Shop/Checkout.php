<?php
declare(strict_types=1);

namespace App\Controller\UI\Shop;

use _PHPStan_76800bfb5\Nette\Neon\Exception;
use App\Controller\UI\Stripe\StripeTrait;
use App\Entity\Order\Line;
use App\Entity\Order\Order;
use App\Repository\CustomerRepository;
use App\Repository\Order\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Currency;

class Checkout extends AbstractController
{
    use StripeTrait;

    /**
     * @Route("/boutique/paiement", name="ui_shop_checkout")
     * @param CustomerRepository $customerRepository
     * @param OrderRepository $orderRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \Stripe\Exception\ApiErrorException
     * @throws Exception
     */
    public function checkout(
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $customer = $customerRepository->findOneBy([]);
        $stripe = $this->getClient();

        $order = $orderRepository->findOneBy([
            'customer' => $customer,
            'state' => Order::CART
        ]);

        if ($customer->getStripeId() === null) {

            $customerStripe = $stripe->customers->create([
                'email' => $customer->getUser()->getEmail(),
                'name' => $customer->getFullName()
            ]);

            $customer->setStripeId($customerStripe->id);
            $entityManager->flush();
        }

        if (!isset($customerStripe)) {
            $customerStripe = $stripe->customers->retrieve($customer->getStripeId());
        }

        $cards = $stripe->paymentMethods->all([
            'customer' => $customerStripe->id,
            'type' => 'card',
        ]);

        if (count($cards->data) > 0) {
            $card = $cards->data[0];
        } else {
            throw new Exception('Aucun méthode de paiement.');
        }


        $total = 0;
        if ($order && $card) {
            /** @var Line $line */
            foreach ($order->getLines() as $line) {
                $total += $line->getAmount();
            }

            $payment = $stripe->paymentIntents->create([
                'amount' => $total*100,
                'currency' => 'eur',
                'confirm' => true,
                'customer' => $customer->getStripeId(),
                'payment_method_types' => ['card'],
                'payment_method' => $card->id
            ]);

            if ($payment->status === 'succeeded') {
                $order->setState(Order::SUCCESS);
                $order->setStripeId($payment->id);
            } else {
                $order->setState(Order::REFUSED);
            }

            $entityManager->flush();

            return $this->redirectToRoute('ui_home_index');
        }

        return $this->render('ui/shop/checkout.html.twig');
    }

}
