<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class AreaController extends Controller
{
    public function index()
    {
        $url = rtrim((string) env('URL_SERVER_API'), '/');
        $response = Http::acceptJson()->get($url . '/areas');
        $areas = $response->successful() ? $response->json() : [];
        $areas = data_get($areas, 'data', $areas);
        $areas = is_array($areas) ? $areas : [];

        $search = trim((string) request('search', ''));

        if ($search !== '') {
            $areas = array_filter($areas, function ($area) use ($search) {
                $searchable = implode(' ', [
                    data_get($area, 'name', ''),
                    data_get($area, 'area_name', ''),
                    data_get($area, 'description', ''),
                ]);

                return mb_stripos($searchable, $search) !== false;
            });
        }

        return view('areas.index', compact('areas'));
    }
}
