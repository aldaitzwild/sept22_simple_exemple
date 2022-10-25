<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function list(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();

        return $this->twig->render('Product/list.html.twig', ['products' => $products]);
    }
}
