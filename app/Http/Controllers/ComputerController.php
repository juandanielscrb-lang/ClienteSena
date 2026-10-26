<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComputerController extends Controller
{
    private function apiUrl()
    {
        return rtrim((string) env('URL_SERVER_API'), '/');
    }

    public function index()
    {
        try {
            $response = Http::acceptJson()
                ->connectTimeout(5)
                ->timeout(30)
                ->get($this->apiUrl() . '/computers');
        } catch (ConnectionException) {
            return view('computers.index', [
                'computers' => [],
                'apiError' => 'No se pudo conectar con la API de computadores. Verifica que el servidor esté activo y que la ruta configurada sea correcta.',
            ]);
        }

        if (! $response->successful()) {
            $status = $response->status();
            $apiError = $status >= 500
                ? 'El servidor de la API falló internamente (HTTP ' . $status . '). Revisa el registro de errores del backend.'
                : ($status === 404
                    ? 'La ruta de computadores no existe en la API (HTTP 404).'
                    : 'La API respondió con HTTP ' . $status . '.');

            return view('computers.index', [
                'computers' => [],
                'apiError' => $apiError,
            ]);
        }

        $computers = data_get($response->json(), 'data', $response->json());
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

    public function create()
    {
        return view('computers.create');
    }

    public function store(Request $request)
    {
        // 1. Validamos que los campos de texto y el archivo de imagen sean correctos
        $request->validate([
            'number'  => ['required', 'string', 'max:255'],
            'brand'   => ['required', 'string', 'max:255'],
            'imagen'  => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // Validamos el archivo real
        ]);

        // 2. Preparamos la petición HTTP para aceptar JSON
        $http = Http::acceptJson();

        // 3. Adjuntamos la imagen si el usuario la seleccionó
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $http->attach(
                'imagen', // Nombre del campo que espera la API
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        // 4. Enviamos los campos de texto junto con el archivo adjunto mediante POST a la API
        try {
            $response = $http
                ->connectTimeout(5)
                ->timeout(60)
                ->post($this->apiUrl() . '/computers', [
                    'number' => $request->number,
                    'brand'  => $request->brand,
                ]);
        } catch (ConnectionException) {
            return back()
                ->withErrors([
                    'error' => 'La API no respondió a tiempo. El computador podría haberse guardado; revisa el listado antes de volver a enviarlo para evitar duplicados.',
                ])
                ->withInput();
        }

        if ($response->successful()) {
            return redirect()->route('computers.index')->with('success', 'Computador creado exitosamente con imagen.');
        }

        $errors = $response->json('errors') ?: [
            'error' => $response->json('message', 'No se pudo crear el computador.'),
        ];

        return back()->withErrors($errors)->withInput();
    }

    public function show($id)
    {
        $response = Http::acceptJson()->get($this->apiUrl() . '/computers/' . $id);

        if (! $response->successful()) {
            return redirect()->route('computers.index')->with('error', 'No se pudo cargar el computador.');
        }

        $computer = data_get($response->json(), 'data', $response->json());

        return view('computers.show', compact('computer'));
    }

    public function edit($id)
    {
        $response = Http::acceptJson()->get($this->apiUrl() . '/computers/' . $id);

        if (! $response->successful()) {
            return redirect()->route('computers.index')->with('error', 'No se pudo cargar el computador para editarlo.');
        }

        $computer = data_get($response->json(), 'data', $response->json());

        return view('computers.edit', compact('computer'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'number' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'urlFoto' => ['nullable', 'string', 'max:2048'],
        ]);

        $response = Http::acceptJson()->put($this->apiUrl() . '/computers/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('computers.index')->with('success', 'Computador actualizado exitosamente.');
        }

        $errors = $response->json('errors') ?: [
            'error' => $response->json('message', 'No se pudo actualizar el computador.'),
        ];

        return back()->withErrors($errors)->withInput();
    }

    public function destroy($id)
    {
        $response = Http::acceptJson()->delete($this->apiUrl() . '/computers/' . $id);

        if ($response->successful()) {
            return redirect()->route('computers.index')->with('success', 'Computador eliminado exitosamente.');
        }

        return redirect()->route('computers.index')->with(
            'error',
            $response->json('message', 'No se pudo eliminar el computador.')
        );
    }
}
