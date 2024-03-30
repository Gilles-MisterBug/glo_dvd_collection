<?php

namespace App\Controller;

use App\Repository\ImportMovieRepository;
use App\service\TmdbApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TmdbApi $tmdbApi): Response
    {
//        dump($tmdbApi->getConfiguration());
//        dump($tmdbApi->getSearch('58 MINUTES POUR VIVRE', 1, 'movie'));
//        dump($tmdbApi->getMovie(1573));
//        dump($tmdbApi->getMovie(1573, 'credits'));

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/import/movies', name: 'app_movies')]
    public function movies(ImportMovieRepository $importMovieRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;

        $movies = $importMovieRepository->paginator($page, $limit);


        return $this->render('home/movies.html.twig', [
            'movies' => $movies,
        ]);
    }
}
