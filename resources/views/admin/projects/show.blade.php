@extends('layouts.admin')

@section('content')

<header class="py-5 bg-dark text-white">
    <div class="container  d-flex align-items-center justify-content-between">
        <h1>{{$project->title}}</h1>
    </div>
</header>


<div class="container py-5">
    <div class="d-flex gap-5">
        @if(Str::startsWith($project->cover_image, 'https://'))
            <img width="40%" loading="lazy" src="{{$project->cover_image}}" alt="">
        @else
            <img width="40%" loading="lazy" src="{{asset('storage/' . $project->cover_image)}}" alt="">
        @endif
        <section>
            <a>{{$project->content}}</a> <br><br>

            <strong>See my Project Code from GitHub:</strong> <br>
            <a href="{{$project->link}}">{{$project->link}}</a> <br><br>


            <strong>Type:</strong>
            <p>{{$project->type ? $project->type->name : 'Uncategorized'}}</p>

            <strong>Technologies:</strong> <br>
            @forelse ($project->technologies as $technology)
                <span class="badge bg-dark">{{$technology->name}}</span>
            @empty
                <span class="badge bg-dark">Nothing Here</span>
            @endforelse
            <!-- <strong>Author</strong>{{$project->user ? $project->user->name : 'N/A'}} -->
        </section>
    </div>
</div>

@endsection