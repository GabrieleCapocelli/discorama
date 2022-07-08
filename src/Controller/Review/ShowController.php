<?php

namespace App\Controller\Review;

use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
use Error;

#[Route('/api/reviews')]
class ShowController extends AbstractController
{
    #[Route('/{id}', name: 'app_review_show', methods: ['GET'])]
    public function show(?Review $review): Response
    {   
        try{
            return $this->json(
                                $review, 
                                200, 
                                ['Content-type: application/json'],
                                ['circular_reference_handler' => function ($object) {return $object->getId();}]
                            );
        }catch(PDOException $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}