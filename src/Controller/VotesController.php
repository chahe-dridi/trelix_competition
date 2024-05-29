<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Form\VoteType;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
#[Route('/votes')]
class VotesController extends AbstractController
{
  /*  #[Route('/', name: 'app_votes_index', methods: ['GET'])]
    public function index(VoteRepository $voteRepository): Response
    {
        return $this->render('votes/index.html.twig', [
            'votes' => $voteRepository->findAll(),
        ]);
    }*/


    #[Route('/', name: 'app_votes_index', methods: ['GET'])]
    public function index(VoteRepository $voteRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Fetch all votes from the repository
        $allVotesQuery = $voteRepository->findAll();
        
        // Paginate the results
        $votes = $paginator->paginate(
            $allVotesQuery, // Query to paginate
            $request->query->getInt('page', 1), // Get the current page number from the request, default to 1
            10 // Number of items per page
        );
    
        // Render the template with paginated votes
        return $this->render('votes/index.html.twig', [
            'votes' => $votes,
        ]);
    }


    #[Route('/new', name: 'app_votes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vote = new Vote();
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vote);
            $entityManager->flush();

            return $this->redirectToRoute('app_votes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('votes/new.html.twig', [
            'vote' => $vote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_votes_show', methods: ['GET'])]
    public function show(Vote $vote): Response
    {
        return $this->render('votes/show.html.twig', [
            'vote' => $vote,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_votes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vote $vote, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoteType::class, $vote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_votes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('votes/edit.html.twig', [
            'vote' => $vote,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_votes_delete', methods: ['POST'])]
    public function delete(Request $request, Vote $vote, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vote->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_votes_index', [], Response::HTTP_SEE_OTHER);
    }
}
