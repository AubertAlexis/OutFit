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

class Add extends AbstractController
{
    /**
     * @Route("/administrator/add", name="admin_administrator_add", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $administrator = new Administrator();

        $form = $this->createForm(AdministratorType::class, $administrator)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On ajoute le role administrateur à l'utilisateur
            $administrator->getUser()->setRoles([User::ROLE_ADMINISTRATOR]);

            $manager->persist($administrator);
            $manager->flush();
            $this->addFlash('success', 'L\'administrateur a bien été créé.');
            return $this->redirectToRoute('admin_administrator_index');
        }

        return $this->render('admin/administrator/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
