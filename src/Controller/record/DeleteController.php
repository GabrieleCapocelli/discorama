<?php

namespace App\Controller\Record;

use App\Entity\Record;
use App\Repository\RecordRepository;
use App\Repository\ReviewRepository;
use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Error;

#[Route('/api/records')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_record_delete', methods: ['DELETE'])]
    public function delete(Record $record, RecordRepository $recordRepository, ReviewRepository $reviewRepository): Response
    {   
        try{
            $review = new Review;
            $review->genericRecord($reviewRepository, $record, $recordRepository);
            $recordRepository->remove($record, true);
            return new Response('record deleted');
        }catch(Exception $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}

