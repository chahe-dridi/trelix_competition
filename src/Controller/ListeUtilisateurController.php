<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeUtilisateurController extends AbstractController
{
    #[Route('/liste/utilisateur', name: 'app_liste_utilisateur')]
    public function index(UtilisateurRepository $repo): Response
    {
        $utilisateurs = $repo->findAll();
        return $this->render('liste_utilisateur/index.html.twig', [
            'utilisateurs'=>$utilisateurs
        ]);
    }

    
    #[Route('/delete/utilisateur/{id}', name: 'app_utilisateur_delete')]
    public function delete($id,UtilisateurRepository $repo,ManagerRegistry $doctrine){
        $utilisateur = $repo->find($id);
        $doctrine->getManager()->remove($utilisateur);
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('app_liste_utilisateur');
    }
}
