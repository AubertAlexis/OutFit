<?php
declare(strict_types=1);

namespace App\Controller\API\Product;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class Index extends AbstractController
{
    /**
     * @Route("/api/products", name="api_product_index", methods={"GET"})
     * @param ProductRepository $productRepository
     * @return JsonResponse
     */
    public function index(ProductRepository $productRepository): JsonResponse
    {
        return $this->json(data: $productRepository->findBy(['enabled' => true], ['name' => 'ASC']), context: ['groups' => 'product.all']);
    }
}
