<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CourseController extends Controller
{
    public function index()
    {
        $url = rtrim((string) env('URL_SERVER_API'), '/');
        $response = Http::acceptJson()->get($url . '/courses');
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
}
