<?php
declare(strict_types=1);

namespace App\Controller\Admin\Delivery;


use App\Entity\Delivery;
use App\Form\DeliveryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    /**
     * @Route("/delivery/edit/{id}", name="admin_delivery_edit", methods={"GET", "POST"})
     * @param Delivery $delivery
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Delivery $delivery, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(DeliveryType::class, $delivery)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'La méthode de paiement a bien été modifié.');
            return $this->redirectToRoute('admin_delivery_index');
        }

        return $this->render('admin/delivery/edit.html.twig', [
            'form' => $form->createView(),
            'delivery' => $delivery
        ]);
    }
}
