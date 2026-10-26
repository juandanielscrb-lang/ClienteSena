<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
{
    private function apiUrl()
    {
        return rtrim((string) env('URL_SERVER_API'), '/');
    }

    public function index()
    {
        $response = Http::acceptJson()->get($this->apiUrl() . '/areas');
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

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $response = Http::acceptJson()->post($this->apiUrl() . '/areas', $data);

        if ($response->successful()) {
            return redirect()->route('areas.index')->with('success', 'Área creada exitosamente.');
        }

        $errors = $response->json('errors') ?: [
            'error' => $response->json('message', 'No se pudo crear el área.'),
        ];

        return back()->withErrors($errors)->withInput();
    }

    public function show($id)
    {
        $response = Http::acceptJson()->get($this->apiUrl() . '/areas/' . $id);

        if (! $response->successful()) {
            return redirect()->route('areas.index')->with('error', 'No se pudo cargar el área.');
        }

        $area = data_get($response->json(), 'data', $response->json());

        return view('areas.show', compact('area'));
    }

    public function edit($id)
    {
        $response = Http::acceptJson()->get($this->apiUrl() . '/areas/' . $id);

        if (! $response->successful()) {
            return redirect()->route('areas.index')->with('error', 'No se pudo cargar el área para editarla.');
        }

        $area = data_get($response->json(), 'data', $response->json());

        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $response = Http::acceptJson()->put($this->apiUrl() . '/areas/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('areas.index')->with('success', 'Área actualizada exitosamente.');
        }

        $errors = $response->json('errors') ?: [
            'error' => $response->json('message', 'No se pudo actualizar el área.'),
        ];

        return back()->withErrors($errors)->withInput();
    }

    public function destroy($id)
    {
        $response = Http::acceptJson()->delete($this->apiUrl() . '/areas/' . $id);

        if ($response->successful()) {
            return redirect()->route('areas.index')->with('success', 'Área eliminada exitosamente.');
        }

        return redirect()->route('areas.index')->with(
            'error',
            $response->json('message', 'No se pudo eliminar el área.')
        );
    }
}
