<?php

namespace App\Controller\UI\Account\Address;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    /**
     * @Route("/mon-compte/addresse", name="ui_account_address_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param CustomerRepository $customerRepository
     * @return Response
     */
    public function index(CustomerRepository $customerRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $customer = $customerRepository->findOneBy([]);
        $address = new Address();
        $address->setCustomer($customer);

        $form = $this->createForm(AddressType::class, $address)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($address);
            $manager->flush();

            $this->addFlash('success', 'Votre addresse a bien été crée.');
            return $this->redirectToRoute('ui_account_personal');
        }

        return $this->render('ui/account/address/add.html.twig', [
            'form' => $form->createView(),
            'customer' => $customer
        ]);
    }
}