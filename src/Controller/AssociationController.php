<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssociationController extends AbstractController
{
    /**
     * @Route("/association", name="association")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('association/index.html.twig', [
            'godFathers' => $userRepository->findAllUserThanRole('ROLE_GODFATHER'),
            'beneficiaries' => $userRepository->findAllUserThanRole('ROLE_BENEFICIARY'),

        ]);
    }

    /**
     * @Route("/creatassociation/{id1}/{id2}", name="creat_association")
     */
    public function associationCreation(UserRepository $userRepository): Response
    {


        return $this->render('association/index.html.twig', [
            'godFathers' => $userRepository->findAllUserThanRole('ROLE_GODFATHER'),
            'beneficiaries' => $userRepository->findAllUserThanRole('ROLE_BENEFICIARY'),
        ]);
    }
}
