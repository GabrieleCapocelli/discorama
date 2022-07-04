<?php

namespace App\Controller\record;

use App\Entity\Record;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
use Error;

#[Route('/records')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_record_delete', methods: ['DELETE'])]
    public function delete(Record $record, RecordRepository $recordRepository): Response
    {   
        try{
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

