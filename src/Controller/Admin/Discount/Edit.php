<?php
declare(strict_types=1);

namespace App\Controller\Admin\Discount;


use App\Entity\Color;
use App\Entity\Discount;
use App\Form\DiscountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ColorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    /**
     * @Route("/discount/edit/{id}", name="admin_discount_edit", methods={"GET", "POST"})
     * @param Discount $discount
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Discount $discount, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(DiscountType::class, $discount)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'La réduction a bien été modifié.');
            return $this->redirectToRoute('admin_discount_index');
        }

        return $this->render('admin/discount/edit.html.twig', [
            'form' => $form->createView(),
            'discount' => $discount
        ]);
    }
}
