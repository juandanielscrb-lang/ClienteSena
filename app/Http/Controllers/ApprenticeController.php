<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ApprenticeController extends Controller
{
    private function fetchDataFromApi($url)
    {
        $response = Http::acceptJson()->get($url);

        return $response->successful() ? $response->json() : [];
    }

    public function index()
    {
        $url = env('URL_SERVER_API');

        $apprentices = $this->fetchDataFromApi(rtrim($url, '/') . '/apprentices');
        $apprentices = data_get($apprentices, 'data', $apprentices);
        $apprentices = is_array($apprentices) ? $apprentices : [];

        $search = trim((string) request('search', ''));

        if ($search !== '') {
            $apprentices = array_filter($apprentices, function ($apprentice) use ($search) {
                $searchable = implode(' ', [
                    data_get($apprentice, 'name', ''),
                    data_get($apprentice, 'email', ''),
                    data_get($apprentice, 'cell_number', ''),
                ]);

                return mb_stripos($searchable, $search) !== false;
            });
        }

        return view('apprentices.index', compact('apprentices'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $apprentice = $this->fetchDataFromApi(
            $url . '/apprentices/' . $id
        );

        return view('apprentices.show', compact('apprentice'));
    }
}