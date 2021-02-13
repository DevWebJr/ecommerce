<?php

namespace App\Controller;

use App\Classes\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/produits", name="products", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search;

        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $products = $this->productRepository->findByResearch($search);
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/produit/{id}", name="show_one_product", methods={"GET"})
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
