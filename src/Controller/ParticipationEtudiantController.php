<?php

namespace App\Controller;

use App\Entity\Participation;


use App\Entity\Competition;

use App\Form\Participation1Type;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
#[Route('/participation/etudiant')]
class ParticipationEtudiantController extends AbstractController
{
  /*  #[Route('/', name: 'app_participation_etudiant_index', methods: ['GET'])]
    public function index(ParticipationRepository $participationRepository): Response
    {
        $competitions = $this->getDoctrine()->getRepository(Competition::class)->findAll();
    
        return $this->render('participation_etudiant/index.html.twig', [
            'competitions' => $competitions,
        ]);
    }
*/

    #[Route('/', name: 'app_participation_etudiant_index', methods: ['GET'])]
public function index(ParticipationRepository $participationRepository, PaginatorInterface $paginator, Request $request): Response
{
    // Fetch all competitions from the repository
    $allCompetitionsQuery = $this->getDoctrine()->getRepository(Competition::class)->findAll();
    
    // Paginate the results
    $competitions = $paginator->paginate(
        $allCompetitionsQuery, // Query to paginate
        $request->query->getInt('page', 1), // Get the current page number from the request, default to 1
        10 // Number of items per page
    );

    // Render the template with paginated competitions
    return $this->render('participation_etudiant/index.html.twig', [
        'competitions' => $competitions,
    ]);
}

    #[Route('/new', name: 'app_participation_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $participation = new Participation();
        $form = $this->createForm(Participation1Type::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participation);
            $entityManager->flush();

            return $this->redirectToRoute('app_participation_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participation_etudiant/new.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    #[Route('/show', name: 'app_participation_etudiant_show', methods: ['GET'])]
    public function show(ParticipationRepository $participationRepository): Response
    {
        return $this->render('participation_etudiant/show.html.twig', [
            'participations' => $participationRepository->findAll(),
        ]);
    }

   /* public function show(Participation $participation): Response
    {
        return $this->render('participation_etudiant/show.html.twig', [
            'participation' => $participation,
        ]);
    }*/

    #[Route('/{id}/edit', name: 'app_participation_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participation $participation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Participation1Type::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_participation_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participation_etudiant/edit.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_participation_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Participation $participation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($participation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_participation_etudiant_index', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/join/{id}', name: 'app_participation_etudiant_join', methods: ['GET', 'POST'])]
    public function join(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        $participation = new Participation();
        $form = $this->createForm(Participation1Type::class, $participation);

        // Handle the form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associate the participation with the selected competition
            $participation->setIdCompetition($competition);

            // Persist and flush the participation entity
            $entityManager->persist($participation);
            $entityManager->flush();

            // Redirect to a new page (e.g., show participation details)
            return $this->redirectToRoute('app_participation_etudiant_index', ['id' => $participation->getId()]);
        }

        // Render the form for joining the competition
        return $this->render('participation_etudiant/new.html.twig', [
            'form' => $form->createView(),
            'competition' => $competition,
        ]);
    }


}
