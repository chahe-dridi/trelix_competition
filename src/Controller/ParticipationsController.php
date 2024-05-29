<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
#[Route('/participations')]
class ParticipationsController extends AbstractController
{
   /*#[Route('/', name: 'app_participations_index', methods: ['GET'])]
    public function index(ParticipationRepository $participationRepository): Response
    {
        return $this->render('participations/index.html.twig', [
            'participations' => $participationRepository->findAll(),
        ]);
    }*/

    #[Route('/', name: 'app_participations_index', methods: ['GET'])]
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
    return $this->render('participations/index.html.twig', [
        'participations' => $participations,
    ]);
}

    #[Route('/new', name: 'app_participations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $participation = new Participation();
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participation);
            $entityManager->flush();

            return $this->redirectToRoute('app_participations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participations/new.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_participations_show', methods: ['GET'])]
    public function show(Participation $participation): Response
    {
        return $this->render('participations/show.html.twig', [
            'participation' => $participation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_participations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participation $participation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_participations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participations/edit.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_participations_delete', methods: ['POST'])]
    public function delete(Request $request, Participation $participation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($participation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_participations_index', [], Response::HTTP_SEE_OTHER);
    }
}
