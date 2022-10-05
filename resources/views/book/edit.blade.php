@extends('layers.html')


@section('title', $book->name)


@section('main-content')
<form action="{{ route('book.update', $book->book_id) }}" method="post">
    <div class="mb-3">
        <label for="book_id" class="form-label">Book ID</label>
        <input value="{{ $book->book_id }}" class="form-control" id="book_id" disabled>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input value="{{ $book->name }}" class="form-control" id="name" name="name" required>
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
            <option value="{{ $author->author_id }}"
                    @if($book_author_ids->contains($author->author_id)) selected @endif>
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


    <div class="mb-3">
        <label for="created_at" class="form-label">created_at</label>
        <input value="{{ $book->created_at }}" class="form-control" id="created_at" disabled>
    </div>
    <div class="mb-3">
        <label for="updated_at" class="form-label">updated_at</label>
        <input value="{{ $book->updated_at }}" class="form-control" id="updated_at" disabled>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    @method('PATCH')
    @csrf
</form>
<form action="{{route('book.destroy', $book->book_id)}}" method="POST">
    <button type="submit" class="btn btn-danger">Delete</button>
    @method('DELETE')
    @csrf
</form>
<form action="{{route('book.show', $book->book_id)}}">
    <button type="submit" class="btn btn-secondary">Cancel</button>
</form>
@endsection

