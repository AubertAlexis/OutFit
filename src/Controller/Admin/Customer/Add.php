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

class Add extends AbstractController
{
    /**
     * @Route("/customer/add", name="admin_customer_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $customer = new Customer();

        $form = $this->createForm(CustomerType::class, $customer)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Add customer role to the user
            $customer->getUser()->setRoles([User::ROLE_CUSTOMER]);

            $manager->persist($customer);
            $manager->flush();
            $this->addFlash('success', 'Le client a bien été créé.');
            return $this->redirectToRoute('admin_customer_index');
        }

        return $this->render('admin/customer/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
