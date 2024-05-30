<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use Illuminate\Support\Str;
use App\Models\Projects;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.projects.index', ['projects' => Project::orderByDesc('id')->paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $slug = Str::slug($request->title, '-');
        $validated['slug'] = $slug;


        if ($request->has('cover_image')) {


            // if ($project->cover_image) {
            //     Storage::delete($project->cover_image);
            // }

            $image_path = Storage::put('uploads', $validated['cover_image']);
            $validated['cover_image'] = $image_path;
        }

        // @dd($validated);

        $project = Project::create($validated);
        if ($request->has('technologies')) {
            $project->technologies()->attach($validated['technologies']);
        }
        return to_route('admin.projects.index')->with('message', 'Project Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        $selectedTechnologies = $project->technologies->pluck('id')->toArray();
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'selectedTechnologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        $slug = Str::slug($request->title, '-');
        $validated['slug'] = $slug;

        if ($request->has('cover_image')) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            $image_path = Storage::put('uploads', $validated['cover_image']);
            $validated['cover_image'] = $image_path;
        }

        $project->update($validated);

        if ($request->has('technologies')) {
            $project->technologies()->sync($validated['technologies']);
        } else {
            $project->technologies()->sync([]);
        }

        return to_route('admin.projects.edit', $project)->with('message', "Project $project->title Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }

        $project->delete();
        return to_route('admin.projects.index')->with('message', "Project $project->title deleted");
    }
}
