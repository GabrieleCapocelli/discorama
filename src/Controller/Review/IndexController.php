<?php

namespace App\Controller\Review;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Error;

#[Route('/api/reviews')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_review_index', methods: ['GET'])]
    public function index(ReviewRepository $reviewRepository): Response
    {   
        try{
            $reviews = $reviewRepository->findAll();
            return $this->json(
                                $reviews, 
                                200, 
                                ['Content-type: application/json'],
                                ['circular_reference_handler' => function ($object) {return $object->getId();}]
                            );
        }catch(Exception $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}