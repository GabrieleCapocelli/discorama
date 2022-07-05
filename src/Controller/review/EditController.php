<?php

namespace App\Controller\review;

use App\Repository\ReviewRepository;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use PDOException;
use Error;

#[Route('/reviews')]
class EditController extends AbstractController
{   
    #[Route('/{id}', name: 'app_review_edit', methods: ['PUT'])]
    public function edit(Request $request, $id, ReviewRepository $reviewRepository, RecordRepository $recordRepository, ValidatorInterface $validator): Response
    {   
        try{
            $review = $reviewRepository->findOneBy(['id'=>$id]);
            $review_post = $request->getContent();
            $review->globalSetter($review_post, $recordRepository );
            $violations = $validator->validate($review);
            if(count($violations)>0){
                $response = new Response('invalid data');
                $response->setStatusCode(400);
            }else{
                $reviewRepository->add($review,true);
                $response = new Response('review updated');
                $response->setStatusCode(200);
            }
            $response->headers->set('Content-Type','application/json');
            return $response;
        }catch(PDOException $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}