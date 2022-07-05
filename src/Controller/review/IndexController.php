<?php

namespace App\Controller\review;

use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
use Error;

#[Route('/reviews')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_review_index', methods: ['GET'])]
    public function index(ReviewRepository $reviewRepository): Response
    {   
        try{
            $reviews = $reviewRepository->findAll();
            return $this->json($reviews);
        }catch(PDOException $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            echo $this->json(['alert'=>$e->getMessage()]);
        }
        
    }
}