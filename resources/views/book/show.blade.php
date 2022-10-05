@extends('layers.html')


@section('title', $book->name)


@section('main-content')
<form action="{{ route('book.edit', $book->book_id) }}">
    <div class="mb-3">
        <label for="book_id" class="form-label">Book ID</label>
        <input value="{{ $book->book_id }}" class="form-control" id="book_id" disabled>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input value="{{ $book->name }}" class="form-control" id="name" name="name" disabled>
    </div>
    <div class="mb-3">
        <label for="author" class="form-label">Authors</label>
        <select class="form-control" id="author" name="author" multiple disabled>
            @foreach($book->author as $author)
                <option value="{{ $author->author_id }}" selected>
                    {{ $author->name }}
                </option>
            @endforeach
        </select>
    </div>


    <div class="mb-3">
        <label for="created_at" class="form-label">created_at</label>
        <input value="{{ $book->created_at }}" class="form-control" id="created_at" disabled>
    </div>
    <div class="mb-3">
        <label for="updated_at" class="form-label">updated_at</label>
        <input value="{{ $book->updated_at }}" class="form-control" id="updated_at" disabled>
    </div>

    <button type="submit" class="btn btn-primary">Edit</button>
</form>
<form action="{{route('book.destroy', $book->book_id)}}" method="POST">
    <button type="submit" class="btn btn-danger">Delete</button>
    @method('DELETE')
    @csrf
</form>
@endsection

