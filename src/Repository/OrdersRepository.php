<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Orders::class);
        $this->manager = $manager;
    }

    public function addOrders($ordersCode, $productId, $quantity, $address, $shippingDate)
    {
        $orders = new Orders();

        $orders->setOrdersCode($ordersCode)->setProductId($productId)->setQuantity($quantity)->setAddress($address)->setShippingDate($shippingDate);

        $this->manager->persist($orders);
        $this->manager->flush();
    }

    public function updateOrders(Orders $orders): Orders
    {
        $this->manager->persist($orders);
        $this->manager->flush();

        return $orders;
    }

    public function removeOrders(Orders $orders)
    {
        $this->manager->remove($orders);
        $this->manager->flush();
    }
}