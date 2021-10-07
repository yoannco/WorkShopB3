<?php

namespace App\Controller;

use App\Repository\UserRepository;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssociationController extends AbstractController
{

    /**
     * @Route("/createassociation", name="create_association")
     */
    public function associationCreation(Request $request, UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $idGodfather = $request->request->get('flexRadioGodFather');
        $idBeneficiary = $request->request->get('flexRadioBeneficiary');
        $idAssociation = rand(1, 1000);
        if (!empty($idGodfather) && !empty($idBeneficiary) ){
            $nameBeneficiary = $userRepository->find((int)$idBeneficiary)->getName() . " " . $userRepository->find((int)$idBeneficiary)->getFirstName();
            $nameGodfather = $userRepository->find((int)$idGodfather)->getName() . " " . $userRepository->find((int)$idGodfather)->getFirstName();
            $userRepository->updateUserById($idAssociation, $idGodfather, $nameBeneficiary);
            $userRepository->updateUserById($idAssociation, $idBeneficiary,$nameGodfather);
        }

        return $this->render('association/index.html.twig', [
            'godFathers' => $userRepository->findAllUserThanRole('ROLE_GODFATHER'),
            'beneficiaries' => $userRepository->findAllUserThanRole('ROLE_BENEFICIARY'),
            'users' => $users
        ]);
    }
}
