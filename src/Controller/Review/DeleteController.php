<?php

namespace App\Controller\Review;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Error;


#[Route('/api/reviews')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_review_delete', methods: ['DELETE'])]
    public function delete(Review $review, ReviewRepository $reviewRepository): Response
    {   
        try{
            $this->denyAccessUnlessGranted('REVIEW_DELETE',$review);
            $reviewRepository->remove($review, true);
            return new Response('review deleted');
        }catch(Exception $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}