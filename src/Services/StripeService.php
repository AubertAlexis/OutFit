<?php
declare(strict_types=1);

namespace App\Services;


use Stripe\Card;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Source;
use Stripe\StripeClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StripeService
{
    private StripeClient $client;
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
        $this->client = new StripeClient($this->parameterBag->get('stripe_sk'));
    }

    /**
     * Create a customer with email and name
     * @param string $email
     * @param string $name
     * @return Customer
     * @throws ApiErrorException
     */
    public function createCustomer(string $email, string $name): Customer
    {
        return $this->client->customers->create([
            'email' => $email,
            'name' => $name
        ]);
    }

    /**
     * Create card for given customer
     * @param string $customer
     * @param string $token
     * @return Card
     * @throws ApiErrorException
     */
    public function createCard(string $customer, string $token): Card
    {
        return $this->client->customers->createSource($customer, ['source' => $token]);
    }

    /**
     * Charge a customer
     * @param int $amount
     * @param string $customer
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function pay(int $amount, string $customer): PaymentIntent
    {
        return $this->client->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'eur',
            'confirm' => true,
            'customer' => $customer
        ]);
    }

    /**
     * Get a customer by id
     * @param string $customer
     * @return Customer
     * @throws ApiErrorException
     */
    public function getCustomer(string $customer): Customer
    {
        return $this->client->customers->retrieve($customer);
    }
}
