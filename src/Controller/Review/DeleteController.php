<?php

namespace App\Controller\Review;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
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
            $response = new Response('review deleted');
            return $response;
        }catch(PDOException $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}