<?php
declare(strict_types=1);

namespace App\Controller\Admin\Category;


use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Delete extends AbstractController
{
    /**
     * @Route("/category/delete/{id}", name="admin_category_delete", methods={"POST"})
     * @param Category $category
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Category $category, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = (string) $request->request->get('token');

        if ($this->isCsrfTokenValid('delete-category', $submittedToken)) {
            $manager->remove($category);
            $manager->flush();

            $this->addFlash('success', 'La catégorie a bien été supprimé.');
            return $this->redirectToRoute('admin_category_index');
        }

        $this->addFlash('danger', 'Une erreur s\'est produite, la validation du token est incorrecte.');
        return $this->redirectToRoute('admin_category_index');
    }
}
