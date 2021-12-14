<?php
declare(strict_types=1);

namespace App\Controller\UI\Stripe;

use Stripe\StripeClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

trait StripeTrait {

    private StripeClient $client;
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
        $this->client = new StripeClient($this->parameterBag->get('stripe_sk'));
    }

    /**
     * @return StripeClient|null
     */
    public function getClient(): ?StripeClient
    {
        return $this->client ?? null;
    }
}
