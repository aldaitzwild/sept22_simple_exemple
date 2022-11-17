<?php

namespace App\Controller;

use App\Model\ProductManager;

class BasketController extends AbstractController
{
    public function add(int $id): string
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);

        $products = [];
        if (isset($_SESSION['basket'])) {
            $products = $_SESSION['basket'];
        }
        $products[] = $product;
        $_SESSION['basket'] = $products;

        $sum = 0;
        foreach ($products as $product) {
            $sum += $product['price'];
        }

        return $this->twig->render('Basket/summary.html.twig', [
            'products' => $products,
            'total' => $sum
        ]);
    }
}
