<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Review;
use App\Repository\UserRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PDOException;
use Error;


#[Route('/api/users')]
class DeleteController extends AbstractController
{
    #[Route('/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function delete(User $user, ReviewRepository $reviewRepository, UserRepository $userRepository): Response
    {
        try{
            $this->denyAccessUnlessGranted('USER_DELETE',$user);
            $review = new Review;
            $review->anonymizeUser($reviewRepository, $user, $userRepository);
            $userRepository->remove($user, true);
           return new Response('User deleted');
        }catch(PDOException $e){
           return $this->json(['alert'=>$e->getMessage()]);
        }catch(Error $e){
            return $this->json(['alert'=>$e->getMessage()]);
        }
    }
}