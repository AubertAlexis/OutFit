<?php
declare(strict_types=1);

namespace App\Controller\Admin\Color;


use App\Entity\Color;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ColorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    /**
     * @Route("/color/edit/{id}", name="admin_color_edit", methods={"GET", "POST"})
     * @param Color $color
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Color $color, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ColorType::class, $color)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'La couleur a bien été modifié.');
            return $this->redirectToRoute('admin_color_index');
        }

        return $this->render('admin/color/edit.html.twig', [
            'form' => $form->createView(),
            'color' => $color
        ]);
    }
}
