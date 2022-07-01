<?php

namespace App\Controller\category;

use App\Entity\Category;
use App\Form\Category1Type;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;


#[Route('/categories')]
class EditController extends AbstractController
{
    #[Route('/{id}', name: 'app_category_edit', methods: ['GET', 'PUT'])]
    public function edit(Request $request, $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['id'=>$id]);
        $category_post = json_decode($request->getContent(),true);
        $form = $this->createForm(Category1Type::class, $category);
        $form->submit($category_post);
        $validator = Validation::createValidator();
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
    }
}