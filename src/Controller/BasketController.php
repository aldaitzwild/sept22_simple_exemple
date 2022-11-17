<?php

namespace App\Controller;

use App\Model\OrderListManager;
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

    public function finalize(): string
    {
        $products = [];
        if (isset($_SESSION['basket'])) {
            $products = $_SESSION['basket'];
        }

        if (empty($products)) {
            return "Il n'y a pas de produit !";
        }

        $order = ['summary' => "", 'total' => 0];

        foreach ($products as $product) {
            $order['summary'] .= $product['name'] . '|' . $product['price'] . ',';
            $order['total'] += $product['price'];
        }

        $orderListManager = new OrderListManager();
        $orderListManager->insert($order);

        unset($_SESSION['basket']);

        return "Youpi ca marche !";
    }
}
