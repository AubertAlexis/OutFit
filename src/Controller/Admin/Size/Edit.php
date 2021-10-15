<?php
declare(strict_types=1);

namespace App\Controller\Admin\Size;


use App\Entity\Size;
use App\Form\SizeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    /**
     * @Route("/size/edit/{id}", name="admin_size_edit", methods={"GET", "POST"})
     * @param Size $size
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Size $size, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(SizeType::class, $size)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'La taille a bien été modifié.');
            return $this->redirectToRoute('admin_size_index');
        }

        return $this->render('admin/size/edit.html.twig', [
            'form' => $form->createView(),
            'size' => $size
        ]);
    }
}
