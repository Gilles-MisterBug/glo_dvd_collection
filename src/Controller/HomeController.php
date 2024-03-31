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

}
