<?php

namespace App\Controller\Category;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Exception;
use Error;

#[Route('/api/categories')]
class EditController extends AbstractController
{
    #[Route('/{id}', name: 'app_category_edit', methods: ['PUT'])]
    public function edit(Request $request, $id, CategoryRepository $categoryRepository, ValidatorInterface $validator): Response
    {   
        try{
            $category = $categoryRepository->findOneBy(['id'=>$id]);
            $category_post = $request->getContent();
            $category->globalSetter($category_post);
            $violations = $validator->validate($category);
            if(count($violations)>0){
                $response = new Response('invalid data');
                $response->setStatusCode(400);
            }else{
                $categoryRepository->add($category,true);
                $response = new Response('category updated');
                $response->setStatusCode(200);
            }
            $response->headers->set('Content-Type','application/json');
            return $response;
        }catch(Exception $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}