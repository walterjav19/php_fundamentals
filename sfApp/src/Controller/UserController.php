<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\ORM\EntityManagerInterface;

final class UserController extends AbstractController
{

    // public function index(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'user controller',
    //         'path' => 'src/Controller/UserController.php',
    //     ]);
    // }


    public function getUsers(UsersRepository $usersRepository): Response
    {

         $users = $usersRepository->findBy(
            ['status' => 1], // Filtrar por usuarios activos
            ['id' => 'DESC'] // Ordenar por ID de forma descendente 
            );

        return $this->render('user/users.html.twig', ["users"=>$users]);
    }


    public function createUser(Request $request,EntityManagerInterface $entityManager): Response{
        
        $users=new Users();

        $form_users=$this->createForm(UsersType::class, $users);

        $form_users->handleRequest($request);

        if ($form_users->isSubmitted() && $form_users->isValid()) {

            $users->setStatus(1); // Siempre activo

  
            $entityManager->persist($users);
            $entityManager->flush();



            return $this->redirectToRoute('getUsers');

        }

        return $this->render('user/create_user.html.twig', [
            'form_users' => $form_users->createView(),
        ]);
        
    }

    public function editUser($id, Request $request, UsersRepository $usersRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $usersRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form_users = $this->createForm(UsersType::class, $user);
        $form_users->handleRequest($request);

        if ($form_users->isSubmitted() && $form_users->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('getUsers');
        }

        return $this->render('user/edit_user.html.twig', [
            'form_users' => $form_users->createView(),
            'user' => $user,
        ]);
    }


    public function deleteUser($id,UsersRepository $usersRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $usersRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Cambiar el estado a 0 (inactivo)
        $user->setStatus(0);

        // Guardar los cambios
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('getUsers');    
 
    }
}
