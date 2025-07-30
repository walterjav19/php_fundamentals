<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{

    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'user controller',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
}
