<?php

namespace App\Controller\User;


use App\Entity\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Exception;
use Error;

#[Route('/api/users')]
class EditController extends AbstractController
{
    #[Route('/{id}', name: 'app_review_edit', methods: ['PUT'])]
    public function edit(User $account, Request $request, $id, UserRepository $userRepository, UserPasswordHasherInterface $hasher, ValidatorInterface $validator): Response
    {
        try{
            $this->denyAccessUnlessGranted('USER_EDIT',$account);
            $user = $userRepository->findOneBy(['id'=>$id]);
            $user_post = $request->getContent();
            $user->globalSetter($user_post, $hasher);
            $violations = $validator->validate($user);
            if(count($violations)>0){
                $response = new Response('invalid data');
                $response->setStatusCode(400);
            }else{
                $userRepository->add($user,true);
                $response = new Response('user updated');
                $response->setStatusCode(200);
            }
            $response->headers->set('Content-Type','application/json');
            return $response;
        }catch(Exception $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }

    }
}