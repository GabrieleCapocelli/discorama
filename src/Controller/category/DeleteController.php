<?php

namespace App\Controller\category;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/categories')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_category_delete', methods: ['DELETE'])]
    public function delete(Category $category, CategoryRepository $categoryRepository): Response
    {
        $categoryRepository->remove($category, true);
        $response = new Response('record deleted');
        return $response;
    }    
}