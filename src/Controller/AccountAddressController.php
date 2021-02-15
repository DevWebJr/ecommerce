<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    /**
     * @Route("/compte/adresses", name="account_addresses")
     */
    public function index(): Response
    {
        return $this->render('account/addresses.html.twig');
    }

    /**
     * @Route("/compte/adresse/ajouter", name="account_add_address")
     */
    public function add(): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        return $this->render('account/add_address.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
