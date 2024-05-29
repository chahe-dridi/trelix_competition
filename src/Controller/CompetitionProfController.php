<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Form\Competition1Type;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
#[Route('/competition/prof')]
class CompetitionProfController extends AbstractController
{
   /* #[Route('/', name: 'app_competition_prof_index', methods: ['GET'])]
    public function index(CompetitionRepository $competitionRepository): Response
    {
        return $this->render('competition_prof/index.html.twig', [
            'competitions' => $competitionRepository->findAll(),
        ]);
    }*/

    #[Route('/', name: 'app_competition_prof_index', methods: ['GET'])]
    public function index(CompetitionRepository $competitionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // Fetch all competitions from the repository
        $allCompetitionsQuery = $competitionRepository->findAll();
        
        // Paginate the results
        $competitions = $paginator->paginate(
            $allCompetitionsQuery, // Query to paginate
            $request->query->getInt('page', 1), // Get the current page number from the request, default to 1
            10 // Number of items per page
        );
    
        // Render the template with paginated competitions
        return $this->render('competition_prof/index.html.twig', [
            'competitions' => $competitions,
        ]);
    }

    

    #[Route('/new', name: 'app_competition_prof_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competition = new Competition();
        $form = $this->createForm(Competition1Type::class, $competition);
        $form->handleRequest($request);
    
     if ($form->isSubmitted() && $form->isValid()) {
        $image = $form->get('image')->getData();

        if ($image) {
            $newFilename = uniqid().'.'.$image->guessExtension();

            $competition->setImage($newFilename);
            $image->move(
                $this->getParameter('kernel.project_dir').'/public/uploads',
                $newFilename
            );
        $entityManager->persist($competition);
        $entityManager->flush();

        return $this->redirectToRoute('app_competition_prof_index', [], Response::HTTP_SEE_OTHER);
         
        }
    }
        return $this->renderForm('competition_prof/new.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
      
    }
 

    #[Route('/{id}', name: 'app_competition_prof_show', methods: ['GET'])]
    public function show(Competition $competition): Response
    {
        return $this->render('competition_prof/show.html.twig', [
            'competition' => $competition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_competition_prof_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Competition1Type::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload if a new image is provided
            $image = $form->get('image')->getData();
            if ($image) {
                // Generate a unique filename for the image
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Set the new filename in the entity
                $competition->setImage($newFilename);

                // Move the uploaded image to the uploads directory
                $image->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads',
                    $newFilename
                );
            }

            // Persist the updated competition entity
            $entityManager->flush();

            // Redirect to the competition index page after successful update
            return $this->redirectToRoute('app_competition_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        // Render the edit form template with the competition and form objects
        return $this->render('competition_prof/edit.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_competition_prof_delete', methods: ['POST'])]
    public function delete(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($competition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_competition_prof_index', [], Response::HTTP_SEE_OTHER);
    }
}
