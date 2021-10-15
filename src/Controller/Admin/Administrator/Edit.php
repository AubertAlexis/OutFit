<?php
declare(strict_types=1);

namespace App\Controller\Admin\Administrator;


use App\Entity\Administrator;
use App\Entity\User;
use App\Form\AdministratorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Edit extends AbstractController
{
    /**
     * @Route("/administrator/edit/{id}", name="admin_administrator_edit", methods={"GET", "POST"})
     * @param Administrator $administrator
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Administrator $administrator, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AdministratorType::class, $administrator)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'L\'administrateur a bien été modifié.');
            return $this->redirectToRoute('admin_administrator_index');
        }

        return $this->render('admin/administrator/edit.html.twig', [
            'form' => $form->createView(),
            'administrator' => $administrator
        ]);
    }
}
