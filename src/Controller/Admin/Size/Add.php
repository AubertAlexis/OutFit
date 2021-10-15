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

class Add extends AbstractController
{
    /**
     * @Route("/size/add", name="admin_size_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $size = new Size();

        $form = $this->createForm(SizeType::class, $size)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($size);
            $manager->flush();
            $this->addFlash('success', 'La taille a bien été créé.');
            return $this->redirectToRoute('admin_size_index');
        }

        return $this->render('admin/size/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
