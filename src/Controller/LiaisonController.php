<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LiaisonController extends AbstractController
{
    /**
     * @Route("/liaison", name="liaison")
     */
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('liaison/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
