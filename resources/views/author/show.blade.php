@extends('layers.html')


@section('title', $author->name)


@section('main-content')
    <form action="{{ route('author.edit', $author->author_id) }}">
        <div class="mb-3">
            <label for="author_id" class="form-label">author ID</label>
            <input value="{{ $author->author_id }}" class="form-control" id="author_id" disabled>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input value="{{ $author->name }}" class="form-control" id="name" name="name" disabled>
        </div>
        <div class="mb-3">
            <label for="book" class="form-label">books</label>
            <select class="form-control" id="book" name="book" multiple disabled>
                @foreach($author->book as $book)
                    <option value="{{ $book->book_id }}" selected>
                        {{ $book->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="created_at" class="form-label">created_at</label>
            <input value="{{ $author->created_at }}" class="form-control" id="created_at" disabled>
        </div>
        <div class="mb-3">
            <label for="updated_at" class="form-label">updated_at</label>
            <input value="{{ $author->updated_at }}" class="form-control" id="updated_at" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
    <form action="{{route('author.destroy', $author->author_id)}}" method="POST">
        <button type="submit" class="btn btn-danger">Delete</button>
        @method('DELETE')
        @csrf
    </form>
@endsection

