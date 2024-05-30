@extends('layouts.admin')

@section('content')
<header class="py-5 bg-dark text-white">
    <div class="container">
        <h1>Create a Project:</h1>
    </div>
</header>

<div class="container py-5">
    @include('partials.validation-message')

    <form action="{{route('admin.projects.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-5">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                aria-describedby="titleHelper" placeholder="Title of the Project" value="{{old('title')}}" />
            <small id="titleHelper" class="form-text text-muted">Type the title of the Project</small>
            @error('title')
                <div class="text-danger ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="cover_image" class="form-label">Image</label>
            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" name="cover_image"
                id="cover_image" aria-describedby="cover_imageHelper" placeholder="Title of the Project"
                value="{{old('cover_image')}}" />
            <small id="cover_imageHelper" class="form-text text-muted">Add the cover image of the Project</small>
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
            <small id="linkHelper" class="form-text text-muted">Type the Link of the Project</small>
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
                    <option value="{{$type->id}}" {{$type->id == old('type_id', $type->id) ? 'selected' : ''}}>{{$type->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-5 mb-5">

            @foreach ($technologies as $technology)
                <div class="form-check">
                    <input name="technologies[]" class="form-check-input" type="checkbox" value="{{$technology->id}}"
                        id="technology-{{$technology->id}}" {{ in_array($technology->id, old('technologies', [])) ? 'checked' : ''}}>
                    <label class="form-check-label" for="technology-{{$technology->id}}">{{$technology->name}}</label>
                </div>
            @endforeach
            @error('technologies')
                <div class="text-danger py-3">
                    {{$message}}
                </div>
            @enderror
        </div>


        <div class="mb-5">
            <label for="content" class="form-label">Content</label> <br>
            <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content"
                rows="5">{{old('content')}}</textarea>
            @error('content')
                <div class="text-danger ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create</button>

    </form>
</div>
@endsection