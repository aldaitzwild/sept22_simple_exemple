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

    public function showSelection(): string
    {
        $productManager = new ProductManager();
        $superProducts = $productManager->selectAllTheSuperProducts();

        return $this->twig->render('Product/selection.html.twig', ['products' => $superProducts]);
    }

    public function changeToSuper(int $id): string
    {
        $productManager = new ProductManager();
        $productManager->updateAsSuper($id);

        return $this->list();
    }

    public function add(): string|null
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $data = array_map('trim', $_POST);

            $productManager = new ProductManager();
            $productManager->insert($data);

            header('Location: /products');
            return null;
        }
        return $this->twig->render('Product/add.html.twig');
    }
}
