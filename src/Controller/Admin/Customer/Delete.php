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

class Delete extends AbstractController
{
    /**
     * @Route("/customer/delete/{id}", name="admin_customer_delete", methods={"POST"})
     * @param Customer $customer
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Customer $customer, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = (string) $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-customer', $submittedToken)) {
            $manager->remove($customer);
            $manager->flush();

            $this->addFlash('success', 'Le client a bien été supprimé.');
            return $this->redirectToRoute('admin_customer_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_customer_index');
    }
}
