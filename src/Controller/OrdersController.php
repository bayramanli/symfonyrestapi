<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrdersController
 * @package App\Controller
 *
 * @Route(path="/api/orders")
 */
class OrdersController extends AbstractController
{
    private $ordersRepository;

    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    /**
     * @Route("/add", name="add_orders", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        //$ordersCode = $data['ordersCode'];
        $ordersCode = "HB".rand(100000, 999999); // test amaçlı bu şekilde yapıldı. veritabanında kontrol edilmeli ve uniqe olmalıdır.
        $productId = $data['productId'];
        $quantity = $data['quantity'];
        $address = $data['address'];
        //$shippingDate = $data['shippingDate'];
        $shippingDate = "";
        //$shippingDate = date("Y-m-d", strtotime(date('d')+1)); //test amaçlı bu şekilde yapıldı. Normalde bunun sipariş onaylanması durumnda yapılması gerekiyor.

        if (empty($ordersCode) || empty($productId) || empty($quantity) || empty($address)) {
            return new JsonResponse(['status' => 'Zorunlu alanlar girilmelidir.'], Response::HTTP_NO_CONTENT);
        }

        $this->ordersRepository->addOrders($ordersCode, $productId, $quantity, $address, $shippingDate);

        return new JsonResponse(['status' => 'Sipariş ekleme işlemi başarılı.'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/get/{id}", name="get_orders", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $orders = $this->ordersRepository->findOneBy(['id' => $id]);

        if (empty($orders)) {
            return new JsonResponse(['status' => 'Sipariş bulunamadı.'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $orders->getId(),
            'ordersCode' => $orders->getOrdersCode(),
            'productId' => $orders->getProductId(),
            'quantity' => $orders->getQuantity(),
            'address' => $orders->getAddress(),
            'shippingDate' => $orders->getShippingDate()
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route("/all", name="get_all_orders", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $orders = $this->ordersRepository->findAll();
        $data = [];

        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'ordersCode' => $order->getOrdersCode(),
                'productId' => $order->getProductId(),
                'quantity' => $order->getQuantity(),
                'address' => $order->getAddress(),
                'shippingDate' => $order->getShippingDate()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/update/{id}", name="update_orders", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $orders = $this->ordersRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        //empty($data['ordersCode']) ? true : $orders->setOrdersCode($data['ordersCode']);
        empty($data['productId']) ? true : $orders->setProductId($data['productId']);
        empty($data['quantity']) ? true : $orders->setQuantity($data['quantity']);
        empty($data['address']) ? true : $orders->setAddress($data['address']);
        //empty($data['shippingDate']) ? true : $orders->setShippingDate($data['shippingDate']);

        $updatedOrders = $this->ordersRepository->updateOrders($orders);

        return new JsonResponse($updatedOrders->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/delete/{id}", name="delete_orders", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $orders = $this->ordersRepository->findOneBy(['id' => $id]);

        if (empty($orders)) {
            return new JsonResponse(['status' => 'Sipariş bulunamadı.'], Response::HTTP_NOT_FOUND);
        }

        $this->ordersRepository->removeOrders($orders);

        return new JsonResponse(['status' => 'Sipariş silindi.'], Response::HTTP_OK);
    }
}