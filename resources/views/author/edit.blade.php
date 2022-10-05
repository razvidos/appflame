@extends('layers.html')


@section('title', $author->name)


@section('main-content')
    <form action="{{ route('author.update', $author->author_id) }}" method="post">
        <div class="mb-3">
            <label for="author_id" class="form-label">author ID</label>
            <input value="{{ $author->author_id }}" class="form-control" id="author_id" disabled>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input value="{{ $author->name }}" class="form-control" id="name" name="name" required>
            @if ($errors->has('name'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="books" class="form-label">books</label>
            <select class="form-control" id="books" name="books[]" multiple required>
                @foreach($books as $book)
                    <option value="{{ $book->book_id }}"
                            @if($author_book_ids->contains($book->book_id)) selected @endif>
                        {{ $book->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('books.*'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('books.*') }}
                </div>
            @endif
        </div>


        <div class="mb-3">
            <label for="created_at" class="form-label">created_at</label>
            <input value="{{ $author->created_at }}" class="form-control" id="created_at" disabled>
        </div>
        <div class="mb-3">
            <label for="updated_at" class="form-label">updated_at</label>
            <input value="{{ $author->updated_at }}" class="form-control" id="updated_at" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        @method('PATCH')
        @csrf
    </form>
    <form action="{{route('author.destroy', $author->author_id)}}" method="POST">
        <button type="submit" class="btn btn-danger">Delete</button>
        @method('DELETE')
        @csrf
    </form>
    <form action="{{route('author.show', $author->author_id)}}">
        <button type="submit" class="btn btn-secondary">Cancel</button>
    </form>
@endsection

