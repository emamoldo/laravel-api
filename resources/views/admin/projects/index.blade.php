@extends('layouts.admin')

@section('content')

<header class="py-5 bg-dark text-white">
    <div class="container  d-flex align-items-center justify-content-between">
        <h1>My Projects:</h1>

        <a class="btn btn-primary" href="{{route('admin.projects.create')}}"><i
                class="fas fa-pencil fa-xs fa-fw"></i>Add new Project
        </a>
    </div>
</header>

<div class="container py-5">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="col">Id</th>
                    <th class="col">Image</th>
                    <th class="col">Title</th>
                    <th class="col">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>{{$project->id}}</td>
                        <td>
                            @if(Str::startsWith($project->cover_image, 'https://'))
                                <img width="150" loading="lazy" src="{{$project->cover_image}}" alt="">
                            @else
                                <img width="150" loading="lazy" src="{{asset('storage/' . $project->cover_image)}}" alt="">
                            @endif

                        </td>
                        <td>{{$project->title}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{route('admin.projects.show', $project)}}">
                                <i class="fas fa-eye fa-xs fa-fw"></i>
                            </a>
                            |
                            <a class="btn btn-primary" href="{{route('admin.projects.edit', $project)}}">
                                <i class="fas fa-pencil fa-xs fa-fw"></i>
                            </a>
                            |
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modal-{{$project->id}}">
                                <i class="fas fa-trash fa-xs fa-fw"></i>
                            </button>

                            <div class="modal fade" id="modal-{{$project->id}}" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitle-{{$project->id}}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitle-{{$project->id}}">
                                                Delete project
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            You are trying to delete: <strong>{{$project->title}}</strong>, are you sure?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>

                                            <form action="{{route('admin.projects.destroy', $project)}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">
                                                    Confirm
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td scope="row" colspan="5">
                            There's no Projects yet!!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{$projects->links('pagination::bootstrap-5')}}
</div>

@endsection