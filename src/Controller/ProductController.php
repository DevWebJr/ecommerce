<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/produits", name="products", methods={"GET"})
     */
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="show_one_product", methods={"GET"})
     */
    public function show_one(Product $product): Response
    {

        if(!$product)
        {
            return $this->redirectToRoute('products');
        }
        
        return $this->render('product/show_one_product.html.twig', compact('product'));
    }
}
