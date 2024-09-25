<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
class BluetoothController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://localhost:3000']);
    }

    public function scan()
    {
        $response = $this->client->get('/scan');
        $devices = json_decode($response->getBody()->getContents(), true);
        return response()->json($devices);
    }

    public function connect($id)
    {
        $response = $this->client->get("/connect/{$id}");
        $result = json_decode($response->getBody()->getContents(), true);
        return response()->json($result);
    }
}
