<?php
declare(strict_types=1);

namespace App\Controller\Admin\Discount;


use App\Entity\Color;
use App\Entity\Discount;
use App\Form\ColorType;
use App\Form\DiscountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    /**
     * @Route("/discount/add", name="admin_discount_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $color = new Discount();

        $form = $this->createForm(DiscountType::class, $color)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($color);
            $manager->flush();
            $this->addFlash('success', 'La réduction a bien été créé.');
            return $this->redirectToRoute('admin_discount_index');
        }

        return $this->render('admin/discount/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
