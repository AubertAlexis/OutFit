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

class Add extends AbstractController
{
    /**
     * @Route("/category/add", name="admin_category_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'La taille a bien été créé.');
            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
