<?php
declare(strict_types=1);

namespace App\Controller\Admin\Product;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    /**
     * @Route("/product/delete/{id}", name="admin_product_delete", methods={"POST"})
     * @param Product $product
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = (string) $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-product', $submittedToken)) {
            $manager->remove($product);
            $manager->flush();

            $this->addFlash('success', 'Le produit a bien été supprimé.');
            return $this->redirectToRoute('admin_product_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_product_index');
    }
}
