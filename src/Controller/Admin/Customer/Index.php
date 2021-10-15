<?php
declare(strict_types=1);

namespace App\Controller\Admin\Customer;


use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    /**
     * @Route("/customer", name="admin_customer_index", methods={"GET"})
     * @param CustomerRepository $customerRepository
     * @return Response
     */
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->render('admin/customer/index.html.twig', [
            'datatable' => true,
            'customers' => $customerRepository->findAll()
        ]);
    }
}
