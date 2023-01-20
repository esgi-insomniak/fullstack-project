<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Product;
use Stripe\Checkout\Session;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\CarRepository;
use App\Repository\CarIdentityRepository;
use App\Repository\CarCategoryRepository;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class PaymentController extends AbstractController
{

    public function __construct(OrderRepository $orderRepository, CarRepository $carRepository, CarIdentityRepository $carIdentityRepository, CarCategoryRepository $carCategoryRepository, ImageRepository $imageRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->carRepository = $carRepository;
        $this->carIdentityRepository = $carIdentityRepository;
        $this->carCategoryRepository = $carCategoryRepository;
        $this->imageRepository = $imageRepository;
    }

    public function __invoke($id)
    {
        // 1- Get order in database
        $order = $this->orderRepository->findOneById($id);
        $car = $this->carRepository->findOneById($order->getCar()->getId());
        $carIdentity = $this->carIdentityRepository->findOneById($car->getIdentity());
        $carCategory = $this->carCategoryRepository->findOneBy(['id' => $carIdentity->getCategory()]);
        $imageCar = $car->getImages();
        //return new JsonResponse(["session_id" => "BMW ".$carCategory->getName()." ".$carIdentity->getName()]);
        //2- Create product in Stripe
        \Stripe\Stripe::setApiKey('sk_test_51MRXR1KanJPVHpR6mu816wVhlqu7S1qte3mQLTwSS4OgUCWt4Qgezp9f6vCyGjZdHS0Z253Drt4NOMzurHb30zZ300QTIkmjpF');
        $product = \Stripe\Product::create([
            'name' => "BMW ".$carCategory->getName()." ".$carIdentity->getName(),
            'default_price_data' => [
                'currency' => 'eur',
                'unit_amount' => round($order->getTotalPrice()) * 100,
            ],
        ]);
        return new JsonResponse(["price" => $product->default_price]);
    }

}
