<?php

namespace App\Controller;

use App\Form\EditPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/compte", name="account", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }
    

    /**
     * @Route("/compte/modifier-le-mot-de-passe", name="edit_password", methods={"GET|PUT"})
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        
        $user = $this->getUser();

        $form = $this->createForm(EditPasswordType::class, $user, [
            'method' => 'PUT'
        ]);
        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $old_password = $form->get('old_password')->getData();

            if($encoder->isPasswordValid($user, $old_password))
            {
                $new_password = $form->get('new_password')->getData(); 
                $password = $encoder->encodePassword($user, $new_password);

                $user->setPassword($password);
                $this->entityManager->flush();

                $this->addFlash('info', 'Mot De Passe Mis À Jour');

                return $this->redirectToRoute('account');
            }
            else
            {
                $this->addFlash('danger', 'erreur de saisie');
            }
        }

        return $this->render('account/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
