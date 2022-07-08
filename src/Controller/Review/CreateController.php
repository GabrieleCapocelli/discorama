<?php

namespace App\Controller\Review;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RecordRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use PDOException;
use Error;


#[Route('/api/reviews')]
class CreateController extends AbstractController
{
    #[Route('/', name: 'app_review_new', methods: ['POST'])]
    public function new(UserRepository $userRepository, Request $request, ReviewRepository $reviewRepository, RecordRepository $recordRepository, ValidatorInterface $validator): Response
    {   
        try{
            $review = new Review;
            $review_post = $request->getContent();
            $review->globalSetter($review_post, $recordRepository, $userRepository);
            $violations = $validator->validate($review);
            if(count($violations)>0){
                $response = new Response('invalid data');
                $response->setStatusCode(400);
            }else{
                $reviewRepository->add($review,true);
                $response = new Response('review added');
                $response->setStatusCode(201);
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