<?php

namespace App\Controller\UI\Security;

use App\Entity\Customer;
use App\Entity\User;
use App\Form\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Register extends AbstractController
{

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $customer = new Customer();

        $form = $this->createForm(CustomerType::class, $customer)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On ajoute le role client à l'utilisateur
            $customer->getUser()->setRoles([User::ROLE_CUSTOMER]);
            $customer->getUser()->setPassword($hasher->hashPassword($customer->getUser(), $customer->getUser()->getPassword()));
            
            $manager->persist($customer);
            $manager->flush();
            $this->addFlash('success', 'Votre compte a bien été créé.');
            return $this->redirectToRoute('login');
        }
        return $this->render('ui/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
