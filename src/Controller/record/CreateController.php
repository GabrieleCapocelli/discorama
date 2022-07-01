<?php

namespace App\Controller\record;

use App\Entity\Record;
use App\Form\Record1Type;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;


#[Route('/records')]
class CreateController extends AbstractController
{
    #[Route('/', name: 'app_record_new', methods: ['POST'])]
    public function new(Request $request, RecordRepository $recordRepository): Response
    {
        $record = new Record;
        $record_post = json_decode($request->getContent(),true);
        $form = $this->createForm(Record1Type::class, $record);
        $form->submit($record_post);
        $validator = Validation::createValidator();
        $violations = $validator->validate($record);
        if(count($violations)>0){
            $response = new Response('invalid data');
            $response->setStatusCode(400);
        }else{
            $recordRepository->add($record,true);
            $response = new Response('record added');
            $response->setStatusCode(200);
        }
        $response->headers->set('Content-Type','application/json');
        return $response;
    }    
}