<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function create()
    {
        return view('apprentices.create');
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $response = Http::acceptJson()->post(rtrim($url, '/') . '/apprentices', $request->all());

        if ($response->successful()) {
            return redirect()->route('apprentices.index')->with('success', 'Aprendiz creado exitosamente.');
        }

        return back()->withErrors($response->json('errors') ?? ['error' => 'No se pudo crear el aprendiz.'])->withInput();
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $apprentice = $this->fetchDataFromApi(rtrim($url, '/') . '/apprentices/' . $id);
        $apprentice = data_get($apprentice, 'data', $apprentice);

        return view('apprentices.show', compact('apprentice'));
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $apprentice = $this->fetchDataFromApi(rtrim($url, '/') . '/apprentices/' . $id);
        $apprentice = data_get($apprentice, 'data', $apprentice);

        return view('apprentices.edit', compact('apprentice'));
    }

    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::acceptJson()->put(rtrim($url, '/') . '/apprentices/' . $id, $request->all());

        if ($response->successful()) {
            return redirect()->route('apprentices.index')->with('success', 'Aprendiz actualizado exitosamente.');
        }

        return back()->withErrors($response->json('errors') ?? ['error' => 'No se pudo actualizar el aprendiz.'])->withInput();
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::acceptJson()->delete(rtrim($url, '/') . '/apprentices/' . $id);

        if ($response->successful()) {
            return redirect()->route('apprentices.index')->with('success', 'Aprendiz eliminado exitosamente.');
        }

        return redirect()->route('apprentices.index')->with('error', 'No se pudo eliminar el aprendiz.');
    }
}