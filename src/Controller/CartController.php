<?php

namespace App\Controller;

use App\Classes\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/panier", name="cart")
     */
    public function index(Cart $cart)
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFullCart(),
            'totalPrice' => $cart->getTotal()
            ]);
    }

    /**
     * @Route("/panier/ajouter/produit/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);

        $this->addFlash('success', 'Cet article a été ajouté à votre panier');

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/panier/supprimer/produit/{id}", name="delete_from_cart")
     */
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);
        
        return $this->redirectToRoute('cart');
    }
    
    /**
     * @Route("/panier/diminuer/produit/{id}", name="decrease_from_cart")
     */
    public function decrease(Cart $cart, $id)
    {
        $cart->decrease($id);
        
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/panier/vider", name="remove_cart")
     */
    public function remove(Cart $cart)
    {
        $cart->remove();
        
        $this->addFlash('warning', 'Votre panier a été complètement vidé.');

        return $this->redirectToRoute('cart');
    }
}

