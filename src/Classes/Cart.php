<?php

namespace App\Classes;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id)
    {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id]))
        {
            $cart[$id]++;
        }
        else
        {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function getFullCart() : array
    {
        $cart = $this->session->get('cart', []);

        $fullCart = [];

        if($this->get())
        {
            foreach($this->get() as $id => $quantity)
            {   $productItem = $this->productRepository->find($id);
                if(!$productItem)
                {
                    $this->delete($id);
                    continue;
                }
                
                $fullCart[] = [
                    'product' => $productItem ,
                    'quantity' => $quantity
                ];                
            }
        }
        
        return $fullCart;
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }


    public function delete(int $id)
    {
       $cart = $this->session->get('cart', []);

       unset($cart[$id]);

       return $this->session->set('cart', $cart);
    }

    public function decrease(int $id)
    {
        $cart = $this->session->get('cart', []);
      
        if($cart[$id] > 1)
        {
            $cart[$id]--;
        }
        else
        {
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }

    public function getTotal() : float
    {
        $total = 0;

        foreach($this->getFullCart() as $item)
        {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}

