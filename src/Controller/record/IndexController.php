<?php

namespace App\Controller\Record;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Exception;
use Error;

#[Route('/api/records')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_record_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, RecordRepository $recordRepository, Request $request): Response
    {   
        try{

            $records =  $recordRepository->customFindAll();
            $display = $paginator->paginate($records, $request->query->get('page', 1), 2); 
            // ?page= for chosing page
            return $this->json(
                                $display,
                                200, 
                                ['Content-type: application/json'],
                                ['circular_reference_handler' => function ($object) {return $object->getId();}]
                            );
        }catch(Exception $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}