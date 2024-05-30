@extends('layouts.admin')

@section('content')
<header class="py-5 bg-dark text-white">
    <div class="container">
        <h1>Edit a Project: {{$project->title}}</h1>
    </div>
</header>

<div class="container py-5">

    @include('partials.validation-message')
    @include('partials.session-message')

    <form action="{{route('admin.projects.update', $project)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                aria-describedby="titleHelper" placeholder="Title of the Project" />
            <small id="titleHelper" class="form-text text-muted">Change the title of the Project</small>
            @error('title')
                <div class="text-danger ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-5">
            @if(Str::startsWith($project->cover_image, 'https://'))
                <img width="150" loading="lazy" src="{{$project->cover_image}}" alt="">
            @else
                <img width="150" loading="lazy" src="{{asset('storage/' . $project->cover_image)}}" alt="">
            @endif

            <label for="cover_image" class="form-label p-5"> Update the Image</label>
            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" name="cover_image"
                id="cover_image" aria-describedby="cover_imageHelper" placeholder="Title of the Project"
                value="{{old('cover_image', $project->cover_image)}}" />
            <small id="cover_imageHelper" class="form-text text-muted">Change the Image of the Project</small>
            @error('cover_image')
                <div class="text-danger ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="link" class="form-label">Link</label>
            <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" id="link"
                aria-describedby="linkHelper" placeholder="Link of the Project" />
            <small id="linkHelper" class="form-text text-muted">Change the Link of the Project</small>
            @error('link')
                <div class="text-danger ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="type_id" class="form-label">Type</label>
            <select class="form-select" name="type_id" id="type_id">
                <option selected disabled>Select the Type of the Project</option>
                @foreach ($types as $type)
                    <option value="{{$type->id}}" {{$type->id == old('type_id', $project->type_id) ? 'selected' : ''}}>
                        {{$type->name}}
                    </option>
                @endforeach
            </select>
        </div>

        {{--
                <div class="d-flex gap-5 mb-5">

                    @foreach ($technologies as $technology)
                        @if($errors->any())
                            <div class="form-check">
                                <input name="technologies[]" class="form-check-input" type="checkbox" value=""
                                    id="technology-{{$technology->id}}" {{ in_array($technology->id, old('technologies', [])) ? 'checked' : ''}}>
                                <label class="form-check-label" for="technology-{{$technology->id}}">{{$technology->name}}</label>
                            </div>
                        @else
                            <div class="form-check">
                                <input name="technologies[]" class="form-check-input" type="checkbox" value=""
                                    id="technology-{{$technology->id}}" {{ in_array($technology->id, $project->technologies->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="technology-{{$technology->id}}">{{$technology->name}}</label>
                            </div>
                        @endif
                    @endforeach
                </div>
                @error('technologies')
                    <div class="text-danger py-2">
                        {{$message}}
                    </div>
                @enderror
        --}}

        <div class="d-flex gap-5 mb-5">

            @foreach ($technologies as $technology)


                @if($errors->any())


                    <div class="form-check">
                        <input name="technologies[]" class="form-check-input" type="checkbox" value="{{$technology->id}}"
                            id="technology-{{$technology->id}}" {{ in_array($technology->id, old('technologies', [])) ? 'checked' : ''}}>
                        <label class="form-check-label" for="technology-{{$technology->id}}">{{$technology->name}}</label>
                    </div>
                @else
                    <div class="form-check">
                        <input name="technologies[]" class="form-check-input" type="checkbox" value="{{$technology->id}}"
                            id="technology-{{$technology->id}}" {{ $project->technologies->contains($technology) ? 'checked' : '' }}>
                        <label class="form-check-label" for="technology-{{$technology->id}}">{{$technology->name}}</label>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mb-5">
            <label for="content" class="form-label">Content</label> <br>
            <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content"
                rows="5">{{old('content', $project->content)}}</textarea>
            @error('content')
                <div class="text-danger ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>

    </form>
</div>

@endsection