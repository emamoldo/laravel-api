<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('type', 'technologies')->get();
        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    }

    public function latest()
    {
        $projects = Project::with('type', 'technologies')->take(3)->get();
        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    }
}
