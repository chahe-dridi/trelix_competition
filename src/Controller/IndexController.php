<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(Request $req, ManagerRegistry $doctrine): Response
    {
        $utilisateur = new Utilisateur();
        $formRegister = $this->createForm(UtilisateurType::class, $utilisateur);
        $formRegister->remove('telephone');
        $formRegister->handleRequest($req);
        if($formRegister->isSubmitted() && $formRegister->isValid()){
            $utilisateur->setTelephone(0);
            $doctrine->getManager()->persist($utilisateur);
            $doctrine->getManager()->flush();
        }
        return $this->render('index/index.html.twig', [
            'formRegister' => $formRegister->createView()
        ]);
    }
    

    
}
