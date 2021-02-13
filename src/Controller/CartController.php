<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Product;
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
        $cartComplete = [];

        foreach($cart->get() as $id => $quantity)
        {
            $cartComplete[] = [
                'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cartComplete
        ]);
        
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

    /**
     * @Route("/panier/supprimer/{id}", name="delete_from_cart")
     */
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);
        
        return $this->redirectToRoute('cart');
    }
}

