<?php

namespace App\Controller\record;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/records')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_record_index', methods: ['GET'])]
    public function index(RecordRepository $recordRepository): Response
    {   
        $records = $recordRepository->findAll();
        return $this->json($records);
    }
}