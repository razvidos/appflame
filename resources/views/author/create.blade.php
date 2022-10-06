@extends('layers.html')


@section('title', 'New Author')


@section('main-content')
    <form action="{{ route('author.store') }}" method="POST">
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
            <label for="books" class="form-label">books</label>
            <select class="form-control" id="books" name="books[]" multiple required>
                @foreach($relations as $book)
                    <option value="{{ $book->book_id }}">
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

        <button type="submit" class="btn btn-success">Add</button>
        @csrf
    </form>
@endsection

