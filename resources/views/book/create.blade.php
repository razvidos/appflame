@extends('layers.html')


@section('title', 'New Book')


@section('main-content')
    <form action="{{ route('book.store') }}" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input class="form-control" id="name" name="name" required>
            @if ($errors->has('name'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="authors" class="form-label">Authors</label>
            <select class="form-control" id="authors" name="authors[]" multiple required>
                @foreach($authors as $author)
                    <option value="{{ $author->author_id }}">
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('authors.*'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('authors.*') }}
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Add</button>
        @csrf
    </form>
@endsection

