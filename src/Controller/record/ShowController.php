<?php

namespace App\Controller\record;

use App\Entity\Record;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
use Error;

#[Route('/records')]
class ShowController extends AbstractController
{
    #[Route('/{id}', name: 'app_record_show', methods: ['GET'])]
    public function show(?Record $record): Response
    {   
        try{
            return $this->json($record);
        }catch(PDOException $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}