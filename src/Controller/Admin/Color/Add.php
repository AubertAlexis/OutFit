<?php
declare(strict_types=1);

namespace App\Controller\Admin\Color;


use App\Entity\Color;
use App\Form\ColorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    /**
     * @Route("/color/add", name="admin_color_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $color = new Color();

        $form = $this->createForm(ColorType::class, $color)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($color);
            $manager->flush();
            $this->addFlash('success', 'La couleur a bien été créé.');
            return $this->redirectToRoute('admin_color_index');
        }

        return $this->render('admin/color/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
