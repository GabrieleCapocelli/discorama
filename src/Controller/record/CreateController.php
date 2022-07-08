<?php

namespace App\Controller\Record;

use App\Entity\Record;
use App\Repository\CategoryRepository;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use PDOException;
use Error;


#[Route('/api/records')]
class CreateController extends AbstractController
{
    #[Route('/', name: 'app_record_new', methods: ['POST'])]
    public function new(Request $request, RecordRepository $recordRepository, CategoryRepository $categoryRepository, ValidatorInterface $validator): Response
    {   
        try{
            $record = new Record;
            $record_post = $request->getContent();
            $record->globalSetter($record_post, $categoryRepository );
            $violations = $validator->validate($record);
            if(count($violations)>0){
                $response = new Response('invalid data');
                $response->setStatusCode(400);
            }else{
                $recordRepository->add($record,true);
                $response = new Response('record added');
                $response->setStatusCode(201);
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