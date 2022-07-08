<?php

namespace App\Controller\Record;

use App\Entity\Record;
use App\Repository\RecordRepository;
use App\Repository\ReviewRepository;
use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
use Error;

#[Route('/api/records')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_record_delete', methods: ['DELETE'])]
    public function delete(Record $record, RecordRepository $recordRepository, Review $review, ReviewRepository $reviewRepository): Response
    {   
        try{
            $review = new Review;
            $review->nullRecord($reviewRepository, $record);
            $recordRepository->remove($record, true);
            $response = new Response('record deleted');
            return $response; 
        }catch(PDOException $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}

