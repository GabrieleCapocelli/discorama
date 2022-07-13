<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use PDOException;
use Error;

#[Route('/api/users')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        try {
            $users = $userRepository->findAll();
            return $this->json(
                $users,
                200,
                ['Content-type: application/json'],
                ['circular_reference_handler' => function ($object) {
                    return $object->getId();
                }]
            );
        } catch (PDOException $e) {
            echo $this->json(['alert' => $e->getMessage()]);
        } catch (Error $e) {
            echo $this->json(['alert' => $e->getMessage()]);
        }

    }
}