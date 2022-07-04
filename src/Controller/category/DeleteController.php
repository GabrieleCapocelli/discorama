<?php

namespace App\Controller\category;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
use Error;


#[Route('/categories')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_category_delete', methods: ['DELETE'])]
    public function delete(Category $category, CategoryRepository $categoryRepository): Response
    {   
        try{
            $categoryRepository->remove($category, true);
            $response = new Response('record deleted');
            return $response; 
        }catch(PDOException $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }
        
    }    
}