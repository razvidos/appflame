@extends('layers.html')


@section('title', 'Books')


@section('main-content')
    <a href="{{ route('book.create') }}" class="btn btn-primary">Add Book</a>
    {{ $elements->links() }}

    <table class="table table-striped">
    <thead>
        <tr>
        @foreach (array_keys($elements[0]->toArray()) as $column)
            <th scope="col">
                {{ $column }}
            </th>
        @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach ($elements as $book)
        <tr>
            <td>
                <a href="{{ route('book.edit', $book->book_id) }}">
                    {{ $book->book_id }}
                </a>
            </td>
            <td>
                <a href="{{ route('book.show', $book->book_id) }}">
                    {{ $book->name }}
                </a>
            </td>
            <td>{{ $book->created_at }}</td>
            <td>{{ $book->updated_at }}</td>
            <td>
            @foreach($book->author as $author)
                <a href="{{ route('author.show', $author->author_id) }}">
                    {{ $author->name }}
                </a>,<br>
            @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>

    {{ $elements->links() }}
@endsection

