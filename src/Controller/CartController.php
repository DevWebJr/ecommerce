<?php

namespace App\Controller;

use App\Classes\Cart;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     */
    public function index(Cart $cart)
    {
        dd($cart->get());
        return $this->render('cart/index.html.twig');
    }

    /**
     * @Route("/panier/ajouter/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);
        
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/panier/supprimer", name="remove_cart")
     */
    public function remove(Cart $cart)
    {
        $cart->remove();
        
        return $this->redirectToRoute('products');
    }
}

