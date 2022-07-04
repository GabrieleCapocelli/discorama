<?php

namespace App\Controller\record;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
use Error;

#[Route('/records')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_record_index', methods: ['GET'])]
    public function index(RecordRepository $recordRepository): Response
    {   
        try{
            $records = $recordRepository->findAll();
            return $this->json($records);
        }catch(PDOException $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}