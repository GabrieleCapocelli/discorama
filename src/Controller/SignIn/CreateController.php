<?php

namespace App\Controller\SignIn;

use App\Entity\User;
use App\Repository\UserRepository;
use Error;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/api/sign_in')]
class CreateController extends AbstractController
{
    #[Route('/', name: 'app_user_new', methods: ['POST'])]
    public function new(Request $request, UserRepository $userRepository, ValidatorInterface $validator, UserPasswordHasherInterface $hasher): Response
    {
        try{
            $user = new User;
            $user_post = $request->getContent();
            $user->globalSetter($user_post, $hasher);
            $violations = $validator->validate($user);
            if(count($violations)>0){
                $response = new Response('invalid data');
                $response->setStatusCode(400);
            }else{
                $userRepository->add($user,true);
                $response = new Response('User added');
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