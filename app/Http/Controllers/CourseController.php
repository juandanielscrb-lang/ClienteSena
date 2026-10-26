<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
{
    private function apiUrl()
    {
        return rtrim((string) env('URL_SERVER_API'), '/');
    }

    public function index()
    {
        $response = Http::acceptJson()->get($this->apiUrl() . '/courses');
        $courses = $response->successful() ? $response->json() : [];
        $courses = data_get($courses, 'data', $courses);
        $courses = is_array($courses) ? $courses : [];

        $search = trim((string) request('search', ''));

        if ($search !== '') {
            $courses = array_filter($courses, function ($course) use ($search) {
                $searchable = implode(' ', [
                    data_get($course, 'course_number', ''),
                    data_get($course, 'number', ''),
                    data_get($course, 'day', ''),
                ]);

                return mb_stripos($searchable, $search) !== false;
            });
        }

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_number' => ['required', 'string', 'max:255'],
            'day' => ['nullable', 'string', 'max:255'],
            'area_id' => ['nullable', 'integer'],
            'training_center_id' => ['nullable', 'integer'],
        ]);

        $response = Http::acceptJson()->post($this->apiUrl() . '/courses', $data);

        if ($response->successful()) {
            return redirect()->route('courses.index')->with('success', 'Curso creado exitosamente.');
        }

        $errors = $response->json('errors') ?: [
            'error' => $response->json('message', 'No se pudo crear el curso.'),
        ];

        return back()->withErrors($errors)->withInput();
    }

    public function show($id)
    {
        $response = Http::acceptJson()->get($this->apiUrl() . '/courses/' . $id);

        if (! $response->successful()) {
            return redirect()->route('courses.index')->with('error', 'No se pudo cargar el curso.');
        }

        $course = data_get($response->json(), 'data', $response->json());

        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $response = Http::acceptJson()->get($this->apiUrl() . '/courses/' . $id);

        if (! $response->successful()) {
            return redirect()->route('courses.index')->with('error', 'No se pudo cargar el curso para editarlo.');
        }

        $course = data_get($response->json(), 'data', $response->json());

        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'course_number' => ['required', 'string', 'max:255'],
            'day' => ['nullable', 'string', 'max:255'],
            'area_id' => ['nullable', 'integer'],
            'training_center_id' => ['nullable', 'integer'],
        ]);

        $response = Http::acceptJson()->put($this->apiUrl() . '/courses/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('courses.index')->with('success', 'Curso actualizado exitosamente.');
        }

        $errors = $response->json('errors') ?: [
            'error' => $response->json('message', 'No se pudo actualizar el curso.'),
        ];

        return back()->withErrors($errors)->withInput();
    }

    public function destroy($id)
    {
        $response = Http::acceptJson()->delete($this->apiUrl() . '/courses/' . $id);

        if ($response->successful()) {
            return redirect()->route('courses.index')->with('success', 'Curso eliminado exitosamente.');
        }

        return redirect()->route('courses.index')->with(
            'error',
            $response->json('message', 'No se pudo eliminar el curso.')
        );
    }
}
