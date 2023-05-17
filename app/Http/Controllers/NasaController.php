<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NasaController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.nasa.gov/']);
    }

    public function getAsteroids(Request $request){
        /* 
        /api/nasa/asteroids?date=YYYY-MM-DD
        */
    
        // Obtenemos la fecha
        $date = $request->query('date'); 
    
        // Hacemos la peticion
        $response = $this->client->request('GET', 'neo/rest/v1/feed', [
            'query' => [
                'start_date' => $date,
                'end_date' => $date,
                'api_key' => env('NASA_API_KEY')
            ]
        ]);
    
        // Decodificamos el JSON
        $asteroids = json_decode($response->getBody()->getContents(), true);
    
        // Creamos un array par aalmacenar la info
        $selectedAsteroids = [];
    
        foreach ($asteroids['near_earth_objects'][$date] as $asteroid) {
            $selectedAsteroids[] = [
                'name' => $asteroid['name'],
                'date' => $date,
                'diameter' => $asteroid['estimated_diameter']['kilometers']['estimated_diameter_min'] . ' - ' . $asteroid['estimated_diameter']['kilometers']['estimated_diameter_max'] . ' km'
            ];
        }
    
        return response()->json($selectedAsteroids);
    }

    
    public function getImageOfTheDay(){
        $response = $this->client->request('GET', 'planetary/apod', [
            'query' => [
                'api_key' => env('NASA_API_KEY')
            ]
        ]);
    
        $imageData = json_decode($response->getBody()->getContents(), true);
    
        // Seleccione solo los datos que desea devolver
        $selectedData = [
            'title' => $imageData['title'],
            'date' => $imageData['date'],
            'image' => $imageData['url']
        ];
    
        return response()->json($selectedData);
    }

    public function getMarsRoverPhotos(Request $request){
        $sol = $request->query('sol');
    
        $response = $this->client->request('GET', 'mars-photos/api/v1/rovers/curiosity/photos', [
            'query' => [
                'sol' => $sol,
                'api_key' => env('NASA_API_KEY')
            ]
        ]);
    
        $photos = json_decode($response->getBody()->getContents(), true);
    
        // Seleccione solo los datos que desea devolver
        $selectedPhotos = [];
        foreach ($photos['photos'] as $photo) {
            $selectedPhotos[] = [
                'id' => $photo['id'],
                'image' => $photo['img_src']
            ];
        }
    
        return response()->json($selectedPhotos);


        /* 
        Al hacer la peticion tendremos que seleccionar la url haciendole click, se nos abrira una nueva entana en el postman
        cuando se habra tendremos que hacer click en el desplegable "GET" para seleccionar "VIEW" para poder ver la imagen
        */
    }
    public function getEarthImagery(Request $request)
    {
        $latitude = $request->query('lat');
        $longitude = $request->query('lon');
        
        $response = $this->client->request('GET', "planetary/earth/imagery", [
            'query' => [
                'lon' => $longitude,
                'lat' => $latitude,
                'api_key' => env('NASA_API_KEY')
            ]
        ]);
        
        return response($response->getBody()->getContents(), 200)
            ->header('Content-Type', 'image/png');
    }
    
    


    }
