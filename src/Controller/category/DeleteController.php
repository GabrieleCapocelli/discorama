<?php

namespace App\Controller\Category;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Error;


#[Route('/api/categories')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_category_delete', methods: ['DELETE'])]
    public function delete(Category $category, CategoryRepository $categoryRepository): Response
    {   
        try{
            $categoryRepository->remove($category, true);
            return new Response('record deleted');
        }catch(Exception $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }
        
    }    
}