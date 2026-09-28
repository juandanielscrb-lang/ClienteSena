<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ComputerController extends Controller
{
    public function index()
    {
        $url = rtrim((string) env('URL_SERVER_API'), '/');
        $response = Http::acceptJson()->get($url . '/computers');
        $computers = $response->successful() ? $response->json() : [];
        $computers = data_get($computers, 'data', $computers);
        $computers = is_array($computers) ? $computers : [];

        $search = trim((string) request('search', ''));

        if ($search !== '') {
            $computers = array_filter($computers, function ($computer) use ($search) {
                $searchable = implode(' ', [
                    data_get($computer, 'number', ''),
                    data_get($computer, 'brand', ''),
                ]);

                return mb_stripos($searchable, $search) !== false;
            });
        }

        return view('computers.index', compact('computers'));
    }
}
