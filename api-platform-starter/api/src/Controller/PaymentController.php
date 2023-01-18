<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Product;
use Stripe\Checkout\Session;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AsController]
class PaymentController extends AbstractController
{

    public function createOrder(Request $request, OrderRepository $orderRepository)
    {
        // 1- Get order in database
        $order = $orderRepository->find($request->get('order_id'));

        // 2- Create product in Stripe
        \Stripe\Stripe::setApiKey('sk_test_51MRXR1KanJPVHpR6mu816wVhlqu7S1qte3mQLTwSS4OgUCWt4Qgezp9f6vCyGjZdHS0Z253Drt4NOMzurHb30zZ300QTIkmjpF');
        $product = \Stripe\Product::create([
            'name' => 'Example product',
            'type' => 'good',
        ]);

        // 3- Create checkout session in Stripe
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => 'Example product',
                'description' => 'Example product description',
                'amount' => $order->getAmount() * 100,
                'currency' => $order->getCurrency(),
                'quantity' => 1,
            ]],
            'success_url' => 'http://localhost:80/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost:80/cancel',
        ]);

        // 4- Return checkout session id
        return new JsonResponse(["session_id" => $session->id]);
    }

}
