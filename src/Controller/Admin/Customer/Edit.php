<?php
declare(strict_types=1);

namespace App\Controller\Admin\Customer;


use App\Entity\Customer;
use App\Entity\User;
use App\Form\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    /**
     * @Route("/customer/edit/{id}", name="admin_customer_edit", methods={"GET", "POST"})
     * @param Customer $customer
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Customer $customer, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CustomerType::class, $customer)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Le client a bien été modifié.');
            return $this->redirectToRoute('admin_customer_index');
        }

        return $this->render('admin/customer/edit.html.twig', [
            'form' => $form->createView(),
            'customer' => $customer
        ]);
    }
}
