<?php

//declare(strict_type=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface; //voir scopeClient

class StarWarsAPIservice
 {
    private const BASE_URL = 'https://swapi.py4e.com/api/people/';
    private const ITEM = 'ITEM';
    private const COLLECTION = 'COLLECTION'; //voir enum

    //constructeur httpClient
    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) { 
    }

    //faire appel à l'API avec l'url qui aura peut-être un id ou non
    private function makeRequest(string $type, ?int $id = null): array
    {
        //si l'url a un id alors on récupère l'entrypoint de l'API+id, sinon juste entrypoint
        $url = $id ? self::BASE_URL.$id : self::BASE_URL;
        //la réponse = requête GET grâce à httpclient
        $response = $this->httpClient->request('GET', $url);
        //je récupère les données soit dans COLLECTION (la liste des personnages) soit dans ITEM (les id)
        $data = match ($type) {
            self::COLLECTION => $response->toArray()['results'] ,
            self::ITEM => $response->toArray(),
        };

        return $data;
    }

    //récupérer tous les personnages
    public function getCharacters(): array
    {
        return $this->makeRequest(self::COLLECTION);
    }

    //récupère un personnage
    public function getCharacter(int $id): array{
        return $this->makeRequest(self::ITEM, $id);
    }

 }