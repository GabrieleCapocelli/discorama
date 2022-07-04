<?php

namespace App\Controller\record;


use App\Form\Record1Type;
use App\Repository\RecordRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use PDOException;
use Error;

#[Route('/records')]
class EditController extends AbstractController
{   
    #[Route('/{id}', name: 'app_record_edit', methods: ['PUT'])]
    public function edit(Request $request, $id, RecordRepository $recordRepository, CategoryRepository $categoryRepository, ValidatorInterface $validator): Response
    {   
        try{
            $record = $recordRepository->findOneBy(['id'=>$id]);
            $record_post = $request->getContent();
            $record->globalSetter($record_post, $categoryRepository );
            $violations = $validator->validate($record);
            if(count($violations)>0){
                $response = new Response('invalid data');
                $response->setStatusCode(400);
            }else{
                $recordRepository->add($record,true);
                $response = new Response('record updated');
                $response->setStatusCode(200);
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