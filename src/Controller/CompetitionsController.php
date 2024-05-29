<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;


use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/competitions')]
class CompetitionsController extends AbstractController
{
    #[Route('/', name: 'app_competitions_index', methods: ['GET'])]
    public function index(CompetitionRepository $competitionRepository, Request $request, PaginatorInterface $paginator): Response
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
        return $this->render('competitions/index.html.twig', [
            'competitions' => $competitions,
        ]);
    }

    #[Route('/new', name: 'app_competitions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competition = new Competition();
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                // Move the uploaded file to the desired location
                $imageFile->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads',
                    $newFilename
                );

                // Update the competition entity with the filename
                $competition->setImage($newFilename);
            }

            // Persist the competition entity
            $entityManager->persist($competition);
            $entityManager->flush();

            return $this->redirectToRoute('app_competitions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('competitions/new.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_competitions_show', methods: ['GET'])]
    public function show(Competition $competition): Response
    {
        return $this->render('competitions/show.html.twig', [
            'competition' => $competition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_competitions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                // Move the uploaded file to the desired location
                $imageFile->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads',
                    $newFilename
                );

                // Update the competition entity with the new filename
                $competition->setImage($newFilename);
            }

            // Persist the updated competition entity
            $entityManager->flush();

            return $this->redirectToRoute('app_competitions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('competitions/edit.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_competitions_delete', methods: ['POST'])]
    public function delete(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($competition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_competitions_index', [], Response::HTTP_SEE_OTHER);
    }





    
    

    #[Route('/competitions/stat', name: 'competition_stat', methods: ['GET'])]
    public function competitionStatistics(EntityManagerInterface $entityManager): Response
    {
        // Get EntityManager
        $em = $entityManager;
    
        // Create a DQL query to select the competition id, name, and count of participations
        $query = $em->createQuery(
            'SELECT c.id, c.nom AS competitionName, COUNT(p.id) as participantCount
             FROM App\Entity\Competition c
             LEFT JOIN App\Entity\Participation p WITH c.id = p.idcompetition
             GROUP BY c.id, c.nom'
        );
    
        // Execute the query
        $results = $query->getResult();
    
        // Initialize an array to store participant counts by competition
        $participantsByCompetition = [];
    
        // Process the results
        foreach ($results as $result) {
            // Use the competition name as the key
            $participantsByCompetition[$result['competitionName']] = $result['participantCount'];
        }
    
        // Prepare statistics data
        $statistics = [
            'Competitions by Participant Count' => $participantsByCompetition,
        ];
    
        // Render the template with statistics
        return $this->render('competitions/stat.html.twig', [
            'statistics' => $statistics,
        ]);
    }
     
    

    #[Route('/competitions/pdf', name: 'app_competitions_pdf', methods: ['GET'])]
    public function generateCompetitionPdf(CompetitionRepository $competitionRepository): Response
    {
        // Fetch all competitions from the repository
        $competitions = $competitionRepository->findAll();
    
        // Render the competitions into a PDF using a template
        $pdf = $this->renderView('competitions/competitions_pdf.html.twig', [
            'competitions' => $competitions,
        ]);
    
        // Create options for Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
    
        // Instantiate Dompdf with options
        $dompdf = new Dompdf($options);
    
        // Load HTML content into Dompdf
        $dompdf->loadHtml($pdf);
    
        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
    
        // Render PDF (output)
        $dompdf->render();
    
        // Stream the PDF response
        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }

}

