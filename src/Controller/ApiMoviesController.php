<?php

namespace App\Controller;

use App\Entity\ImportMovie;
use App\Repository\ImportMovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ApiMoviesController extends AbstractController
{
    #[Route('/api/movies', name: 'app_api_movies')]
    public function index(Request $request, ImportMovieRepository $importMovieRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 5;

        $movies = $importMovieRepository->paginator($page, $limit);

//        $movies = $importMovieRepository->findAll();

        return $this->json(
            $movies,
            200,
            [],
            [
                'groups' => 'movies.list'
            ]
        );
    }

    #[Route(
        '/api/movies/{id}',
        name: 'app_api_movies_detail',
        requirements: ['id' => Requirement::DIGITS]
    )]
    public function detail(ImportMovie $movie, Request $request, ImportMovieRepository $importMovieRepository): Response
    {

//        $movie = $importMovieRepository->findById($id);

        return $this->json(
            $movie,
            200,
            [],
            [
                'groups' => 'movies.detail'
            ]
        );
    }
}
