<?php

namespace App\Controller\record;

use App\Entity\Record;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/records')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_record_delete', methods: ['DELETE'])]
    public function delete(Record $record, RecordRepository $recordRepository): Response
    {
        $recordRepository->remove($record, true);
        $response = new Response('record deleted');
        return $response;
    }
}

