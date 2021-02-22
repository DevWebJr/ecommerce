<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart, Request $request): Response
    {

        if(!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_add_address');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFullCart()
        ]);
    }
    
    /**
     * @Route("/commande/details", name="order_details")
     */
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $date = new \DateTime();    
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstName().' '.$delivery->getLastName();
            $delivery_content .= '<br/>' . $delivery->getPhone  ();
            $delivery_content .= '<br/>' . $delivery->getAddress();
            $delivery_content .= '<br/>' . $delivery->getPostal(). ' ' .$delivery->getCity();
            $delivery_content .= '<br/>' . $delivery->getCountry();
            dd($delivery);

            
            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            foreach($cart->getFullCart() as $product)
            {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                
                $this->entityManager->persist($orderDetails);
            }

            $this->entityManager->flush();
        }
        
 
        return $this->render('order/nice.html.twig', [
            'cart' => $cart->getFullCart()
        ]);
    }
}
