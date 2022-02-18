<?php
declare(strict_types=1);

namespace App\Controller\UI\Account;

use App\Entity\Customer;
use App\Entity\User;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Personal extends AbstractController
{

    /**
     * @Route("/mon-compte/informations", name="ui_account_personal", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function personal(Request $request, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted(User::ROLE_CUSTOMER);

        /** @var User $user */
        $user = $this->getUser();
        $customer = $user->getCustomer();

        $form = $this->createForm(CustomerType::class, $customer)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Vos informations ont bien été modifié.');
            return $this->redirectToRoute('ui_account_personal');
        }

        return $this->render('ui/account/personal.html.twig', [
            'form' => $form->createView(),
            'customer' => $customer
        ]);
    }

}
