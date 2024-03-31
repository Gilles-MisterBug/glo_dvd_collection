<?php

namespace App\Controller;

use App\Entity\ImportMovie;
use App\Repository\ImportMovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/import', name: 'app_import_')]
class ImportController extends AbstractController
{
    #[Route('/movies', name: 'movies')]
    public function movies(ImportMovieRepository $importMovieRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;

        $movies = $importMovieRepository->paginator($page, $limit);


        return $this->render('import/movies.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route(
        '/search/movie/tmdb/{id}',
        name: 'search_movie_tmdb',
        requirements: ['id' => Requirement::DIGITS]
    )]
    public function searchMovieTmdb(ImportMovie $movie, Request $request): Response
    {

        return $this->render('import/movies.html.twig', [
            'movie' => $movie,
        ]);
    }


}
