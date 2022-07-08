<?php

namespace App\Controller\Review;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use App\Repository\RecordRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use PDOException;
use Error;

#[Route('/api/reviews')]
class EditController extends AbstractController
{   
    #[Route('/{id}', name: 'app_review_edit', methods: ['PUT'])]
    public function edit(Review $review, Request $request, $id, ReviewRepository $reviewRepository, RecordRepository $recordRepository, UserRepository $userRepository, ValidatorInterface $validator): Response
    {   
        try{
            $this->denyAccessUnlessGranted('REVIEW_EDIT',$review);
            $review = $reviewRepository->findOneBy(['id'=>$id]);
            $review_post = $request->getContent();
            $review->globalSetter($review_post, $recordRepository, $userRepository );
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