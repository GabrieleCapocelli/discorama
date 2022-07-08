<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use Error;

#[Route('/api/users')]
class ShowController extends AbstractController
{
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(?User $user): Response
    {
        try{
            return $this->json(
                $user,
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