<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\ProductManager;

class CategoryController extends AbstractController
{
    public function show(int $id): string
    {
        $categoryManager = new CategoryManager();
        $category = $categoryManager->selectOneById($id);

        $productManager = new ProductManager();
        $products = $productManager->selectByCategory($id);

        return $this->twig->render('Category/show.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }
}
