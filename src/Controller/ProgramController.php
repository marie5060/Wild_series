<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use App\Repository\EpisodeRepository;

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

    #[Route('/{id<^[0-9]+$>}', name: 'show')]
    public function show(int $id, ProgramRepository $programRepository, SeasonRepository $seasonRepository ):Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        // same as $program = $programRepository->find($id);
    
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        
        $seasons = $seasonRepository->findBy(['program'=> $program]);

        return $this->render('program/show.html.twig', [
            'program' => $program, 'seasons' => $seasons
        ]);
    }

    #[Route('/{programId}/season/{seasonId}', name: 'season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository ) :Response 
    
    {
         
        $season = $seasonRepository->findOneById(['seasonId'=> $seasonId]);
        $program = $programRepository->findOneById(['programId' => $programId]);
        $episodes = $episodeRepository->findBy(['season'=> $season]);
        
        return $this->render('program/season_show.html.twig',['programId' => $programId, 'seasonId' => $seasonId,  'program' => $program, 'season' => $season, 'episodes' => $episodes]);
    }
    
}