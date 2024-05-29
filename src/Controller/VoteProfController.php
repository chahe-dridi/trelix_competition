<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use App\Entity\Vote;
use App\Form\Vote1Type;

use App\Repository\VoteRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
#[Route('/vote/prof')]
class VoteProfController extends AbstractController
{

    /*#[Route('/', name: 'app_vote_prof_index', methods: ['GET'])]
    public function index(ParticipationRepository $participationRepository): Response
    {
        $participations = $participationRepository->findAll();

        return $this->render('vote_prof/index.html.twig', [
            'participations' => $participations,
        ]);
    }
*/

    #[Route('/', name: 'app_vote_prof_index', methods: ['GET'])]
    public function index(ParticipationRepository $participationRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Fetch all participations from the repository
        $allParticipationsQuery = $participationRepository->findAll();
        
        // Paginate the results
        $participations = $paginator->paginate(
            $allParticipationsQuery, // Query to paginate
            $request->query->getInt('page', 1), // Get the current page number from the request, default to 1
            10 // Number of items per page
        );
    
        // Render the template with paginated participations
        return $this->render('vote_prof/index.html.twig', [
            'participations' => $participations,
        ]);
    }
    
  #[Route('/new/{id}', name: 'app_vote_prof_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Participation $participation, EntityManagerInterface $entityManager): Response
    {
        $vote = new Vote();
        $vote->setIdParticipation($participation); // Associate vote with the selected participation

        $form = $this->createForm(Vote1Type::class, $vote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vote);
            $entityManager->flush();

            return $this->redirectToRoute('app_vote_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vote_prof/new.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    } 

 
    






    #[Route('/show', name: 'app_vote_prof_show', methods: ['GET'])]
    public function show(VoteRepository $voteRepository): Response
    {
        return $this->render('vote_prof/show.html.twig', [
            'votes' => $voteRepository->findAll(),
        ]);
    }
 
 

    #[Route('/{id}/edit', name: 'app_vote_prof_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vote $vote, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Vote1Type::class, $vote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vote_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vote_prof/edit.html.twig', [
            'vote' => $vote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vote_prof_delete', methods: ['POST'])]
    public function delete(Request $request, Vote $vote, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vote->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vote_prof_index', [], Response::HTTP_SEE_OTHER);
    }







}
