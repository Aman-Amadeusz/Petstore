<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PetController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('PETSTORE_API_URL'),
            'verify' => false,
            'api_key' => "special-key",
        ]);
    }

    public function index(Request $request)
    {   
        //dd($request);
        if($request == null || $request->status == null ){
            $response = $this->client->get("pet/findByStatus", [
                'query' => ['status' => 'available']
            ]);
        }else {
            //dd($request);
            $response = $this->client->get("pet/findByStatus", [
                'query' => ['status' => $request->status]
            ]);
        }

        if($response->getstatusCode() == 400)
        { 
            return redirect()->route('pets.index')->with('message', 'Invalid status value');
        }

        $pets = json_decode($response->getBody()->getContents(), true);
        //dd($pets);
        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }
    
    public function store(Request $request)
    {
        try {
            $response = $this->client->post('pet', [
                'json' => array_merge(['name' => $request->name, 'photoUrls' =>  [$request->photoUrls], 'status' => $request->status ,'id' => $request->id])
            ]);
                return redirect()->route('pets.index')->with('message', 'Add pet');
            
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() == 405) {
                return redirect()->route('pets.index')->with('message', 'Invalid input');
            } else {
                $errorBody = json_decode($e->getResponse()->getBody()->getContents(), true);
                return redirect()->route('pets.index')->with('message', 'API request failed: ' . $errorBody['message']);
            }
        }
    }

    public function edit($id)
    {
       
        try {
            $response = $this->client->get("pet/{$id}");
            $pet = json_decode($response->getBody()->getContents(), true);
            return view('pets.edit', compact('pet'));

        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('pets.index')->with('message', 'Pet not found');
            } else {
                $errorBody = json_decode($e->getResponse()->getBody()->getContents(), true);
                return redirect()->route('pets.index')->with('message', 'API request failed: ' . $errorBody['message']);
            }
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $response = $this->client->put('pet', [
                'json' => array_merge(['name' => $request->name, 'photoUrls' =>  [$request->photoUrls], 'status' => $request->status ,'id' => (int) $id])
            ]);

            return redirect()->route('pets.index')->with('message', 'Edit successful');

        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getResponse()->getStatusCode() == 400) {
                return redirect()->route('pets.index')->with('message', 'Invalid ID supplied');
            } elseif  ($e->hasResponse() && $e->getResponse()->getStatusCode() == 404) {
                return redirect()->route('pets.index')->with('message', 'Pet not found');
            } elseif  ($e->hasResponse() && $e->getResponse()->getStatusCode() == 405) {
                return redirect()->route('pets.index')->with('message', 'Invalid input');
            } else {
                $errorBody = json_decode($e->getResponse()->getBody()->getContents(), true);
                return redirect()->route('pets.index')->with('message', 'API request failed: ' . $errorBody['message']);
            }
        }     
    }

    public function destroy($id)
    {
         try {
            $this->client->delete("pet/{$id}");
            return redirect()->route('pets.index')->with('message', 'Delete successful');
         } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Failed to delete pet']);
         }
      
    }
}
