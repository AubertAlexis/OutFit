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

class Add extends AbstractController
{
    /**
     * @Route("/delivery/add", name="admin_delivery_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $delivery = new Delivery();

        $form = $this->createForm(DeliveryType::class, $delivery)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($delivery);
            $manager->flush();
            $this->addFlash('success', 'La méthode de livraison a bien été créé.');
            return $this->redirectToRoute('admin_delivery_index');
        }

        return $this->render('admin/delivery/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
