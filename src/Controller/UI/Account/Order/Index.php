<?php
declare(strict_types=1);

namespace App\Controller\UI\Account\Order;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{

    /**
     * @Route("/mon-compte/commandes", name="ui_account_order_index")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_CUSTOMER);

        /** @var User $user */
        $user = $this->getUser();
        $customer = $user->getCustomer();

        return $this->render('ui/account/order/index.html.twig', [
            'orders' => $customer->getOrders()
        ]);
    }

}
