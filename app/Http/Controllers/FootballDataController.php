<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class FootballDataController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.football-data.org/v2/',
            'headers' => [
                'X-Auth-Token' => '2c9c8c20cda242b3815eb261e23949c7'
            ]
        ]);
    }

    public function getArea(Request $request, $id)
    {
        $response = $this->client->request('GET', "v2/areas/{$id}");
        $areaDetails = json_decode($response->getBody()->getContents(), true);
    
        $selectedArea = [
            'name' => $areaDetails['name'],
            'country' => $areaDetails['country'],
        ];
    
        return response()->json($selectedArea);
    }
    


    public function getCompetitions(Request $request)
    {
    // http://localhost:8003/api/football/competitions?area=Argentina

        $area = $request->query('area');
    
        $response = $this->client->request('GET', 'competitions');
        $competitions = json_decode($response->getBody()->getContents(), true);
    
        $selectedCompetitions = [];
        foreach ($competitions['competitions'] as $competition) {
            if ($area && strtolower($competition['area']['name']) != strtolower($area)) {
                continue;
            }
            $selectedCompetitions[] = [
                'name' => $competition['name'],
                'area' => $competition['area']['name'],
            ];
        }
    
        return response()->json($selectedCompetitions);
    }
    






    public function getTeams(Request $request, $competitionId)
    {
        $response = $this->client->request('GET', "competitions/{$competitionId}/teams");
        $teams = json_decode($response->getBody()->getContents(), true);
    
        $selectedTeams = [];
        foreach ($teams['teams'] as $team) {
            $selectedTeams[] = [
                'name' => $team['name'],
                'founded' => $team['founded'],
                'venue' => $team['venue'],
            ];
        }
    
        return response()->json($selectedTeams);
    }
    
    
    public function getMatches(Request $request, $id)
    {
        $response = $this->client->request('GET', "competitions/{$id}/matches");
        $matches = json_decode($response->getBody()->getContents(), true);
    
        $selectedMatches = [];
        foreach ($matches['matches'] as $match) {
            $selectedMatches[] = [
                'homeTeam' => $match['homeTeam']['name'],
                'awayTeam' => $match['awayTeam']['name'],
                'score' => $match['score'],
            ];
        }
    
        return response()->json($selectedMatches);
    }
    
    public function getTeam(Request $request)
    {
        $id = $request->query('id');
    
        $response = $this->client->request('GET', "teams/{$id}");
    
        $teamDetails = json_decode($response->getBody()->getContents(), true);
    
        $selectedDetails = [
            'name' => $teamDetails['name'],
            'shortName' => $teamDetails['shortName'],
            'founded' => $teamDetails['founded'],
            'clubColors' => $teamDetails['clubColors'],
        ];
    
        return response()->json($selectedDetails);
    }
    



}
