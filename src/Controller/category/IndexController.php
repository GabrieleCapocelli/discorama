<?php

namespace App\Controller\category;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(categoryRepository $categoryRepository): Response
    {   
        $categories = $categoryRepository->findAll();
        return $this->json($categories);
    }
}