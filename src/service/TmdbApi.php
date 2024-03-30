<?php

namespace App\service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TmdbApi
{
    private array $requestApi = [
        'configuration_detail' => [
            'request' => 'configuration',
            'query' => [],
        ],
        'configuration_countries' => [
            'request' => 'configuration/countries',
            'query' => [],
        ],
        'configuration_jobs' => [
            'request' => 'configuration/jobs',
            'query' => [],
        ],
        'configuration_languages' => [
            'request' => 'configuration/languages',
            'query' => [],
        ],
        'configuration_primary_translations' => [
            'request' => 'configuration/primary_translations',
            'query' => [],
        ],
        'configuration_timezones' => [
            'request' => 'configuration/timezones',
            'query' => [],
        ],
        'search_collection' => [
            'request' => 'search/collection',
            'query' => ['query' => '', 'include_adult' => true, 'language' => 'fr-FR', 'page' => 1, 'region' => ''],
        ],
        'search_multi' => [
            'request' => 'search/multi',
            'query' => ['query' => '', 'include_adult' => true, 'language' => 'fr-FR', 'page' => 1],
        ],
        'search_person' => [
            'request' => 'search/person',
            'query' => ['query' => '', 'include_adult' => true, 'language' => 'fr-FR', 'page' => 1],
        ],
        'search_movie' => [
            'request' => 'search/movie',
            'query' => ['query' => '', 'include_adult' => true, 'language' => 'fr-FR', 'page' => 1, 'region' => '', 'primary_release_year' => '', 'year' => ''],
        ],
        'search_tv' => [
            'request' => 'search/tv',
            'query' => ['query' => '', 'include_adult' => true, 'language' => 'fr-FR', 'page' => 1,  'year' => ''],
        ],
        'search_company' => [
            'request' => 'search/company',
            'query' => ['query' => '', 'page' => 1],
        ],
        'search_keyword' => [
            'request' => 'search/keyword',
            'query' => ['query' => '', 'page' => 1],
        ],
        'movie_detail' => [
            'request' => 'movie/%d',
            'query' => ['language' => 'fr-FR'],
        ],
        'movie_credits' => [
            'request' => 'movie/%d/credits',
            'query' => ['language' => 'fr-FR'],
        ],
    ];

    private string $token;
    private string $url;

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private HttpClientInterface $client
    )
    {
        $this->token = $this->parameterBag->get('tmdb_api')['read_token'];
        $this->url = $this->parameterBag->get('tmdb_api')['base_url'];
    }

    /**
     * @param string $type : define configuration type
     *              values allows : [detail|countries|jobs|languages|primary_translations|timezones]
     * @return array
     */
    public function getConfiguration(string $type = 'detail'): array
    {
        return $this->callApi('GET', $this->requestApi['configuration_' . $type]['request']);
    }

    private function getQuery(array $queryElements): string
    {
        $query = [];

        foreach ($queryElements as $k => $v){
            array_push($query, $k . '=' .$v);
        }

        return implode('&', $query);
    }

    /**
     * @param string $search
     * @param int $page
     * @param string $type : define configuration type
     *               values allows : [collection|keyword|company|movie|multi|person|tv]
     * @return array
     */
    public function getSearch(string $search, int $page = 1, string $type = 'multi'): array
    {
        $request = $this->requestApi['search_' . $type];
        $request['query']['query'] = $search;
        $request['query']['page'] = $page;

        return $this->callApi('GET', $request['request'], $this->getQuery($request['query']));
    }

    /**
     * @param int $id : Movie ID
     * @param string $type : define configuration type
     *                values allows : [detail|credits]
     * @return array
     */
    public function getMovie(int $id = 0, string $type = 'detail'): array
    {
        $request = $this->requestApi['movie_' . $type];

        return $this->callApi('GET', sprintf($request['request'], $id), $this->getQuery($request['query']));
    }

    private function callApi(string $method, string $request, string $query = null): array
    {
        if ($query === null) {
            $request = $this->url . $request;
        } else {
            $request = $this->url . $request . '?'. $query;
        }
        dump($request);

        $response = $this->client->request(
            $method,
            $request,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'accept' => 'application/json',
                ]
            ]
        );

        return $response->toArray();
    }
}