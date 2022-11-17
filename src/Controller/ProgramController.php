<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use App\Repository\EpisodeRepository;

use App\Form\ProgramType;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
             'programs' => $programs
         ]);
    }
    
    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();

        // Create the form, linked with $program
        $form = $this->createForm(programType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $programRepository->add($program, true);
            // Redirect to categories list
        return $this->redirectToRoute('program_index');
        }
        // Render the form (best practice)
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);

    }

    #[Route('/{program}',methods: ['GET'], name: 'show')]
    public function show(Program $program, SeasonRepository $seasonRepository ):Response
    {
        // $program = $programRepository->findOneBy(['id' => $id]);
        // same as $program = $programRepository->find($id);
    
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$program.' found in program\'s table.'
            );
        }
        
        $seasons = $seasonRepository->findBy(['program'=> $program]);

        return $this->render('program/show.html.twig', [
            'program' => $program, 'seasons' => $seasons
        ]);
    }

    #[Route('/{program}/season/{season}', name: 'season_show')]
    public function showSeason( Program $program, Season $season, EpisodeRepository $episodeRepository ) :Response 
    
    {
         
        // $season = $seasonRepository->findOneById(['seasonId'=> $seasonId]);
        // $program = $programRepository->findOneById(['programId' => $programId]);
        $episodes = $episodeRepository->findBy(['season'=> $season]);
        
        // return $this->render('program/season_show.html.twig',['programId' => $programId, 'seasonId' => $seasonId,  'program' => $program, 'season' => $season, 'episodes' => $episodes]);
        return $this->render('program/season_show.html.twig',['program' => $program, 'season' => $season, 'episodes' => $episodes]);
    }

    #[Route('/program/{program}/season/{season}/episode/{episode}', name: 'episode_show')]
    public function showEpisode( Program $program, Season $season, Episode $episode ) :Response 
    
    {
         
        // $season = $seasonRepository->findOneById(['seasonId'=> $seasonId]);
        // $program = $programRepository->findOneById(['programId' => $programId]);
        // $episodes = $episodeRepository->findBy(['season'=> $season]);
        
        // return $this->render('program/season_show.html.twig',['programId' => $programId, 'seasonId' => $seasonId,  'program' => $program, 'season' => $season, 'episodes' => $episodes]);
        
        return $this->render('program/episode_show.html.twig',['program' => $program, 'season' => $season, 'episode' => $episode]);
    }
    
}