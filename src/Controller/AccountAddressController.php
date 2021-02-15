<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, AddressRepository $addressRepository)
    {
        $this->entityManager = $entityManager;
        $this->addressRepository = $addressRepository;
    }

    /**
     * @Route("/compte/adresses", name="account_addresses")
     */
    public function index(): Response
    {
        return $this->render('account/addresses.html.twig');
    }

    /**
     * @Route("/compte/adresses/ajouter-une-adresse", name="account_add_address")
     */
    public function add(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $address->setUser($this->getUser());
            
            $this->entityManager->persist($address);
            $this->entityManager->flush();   

            $this->addFlash('success', 'Cette adresse a été ajoutée.');

            return $this->redirectToRoute('account_addresses');
        }

            return $this->render('account/add_address.html.twig', [
                'form' => $form->createView()
                ]);
    }

    /**
     * @Route("/compte/adresses/modifier-une-adresse/{id}", name="account_edit_address")
     */
    public function edit(Request $request, $id): Response
    {
        $address = $this->addressRepository->find($id);

        if(!$address || $address->getUser() != $this->getUser())
        {
            return $this->redirectToRoute('account_addresses');
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();   

            $this->addFlash('success', 'Cette adresse a été modifiée.');
            
            return $this->redirectToRoute('account_addresses');
        }

            return $this->render('account/edit_address.html.twig', [
                'form' => $form->createView()
                ]);
    }

    /**
     * @Route("/compte/adresses/supprimer-une-adresse/{id}", name="account_delete_address")
     */
    public function delete(Request $request, $id): Response
    {
        $address = $this->addressRepository->find($id);

        if($address || $address->getUser() == $this->getUser())
        {
            $this->entityManager->remove($address);
            $this->entityManager->flush();   
            
            $this->addFlash('danger', 'Cette adresse a été supprimée.');
            
            return $this->redirectToRoute('account_addresses');
        }

            return $this->render('account/edit_address.html.twig');
    }
}
