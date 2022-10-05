@extends('layers.html')


@section('title', 'authors')


@section('main-content')
    <a href="{{ route('author.create') }}" class="btn btn-primary">Add author</a>
    {{ $authors->links() }}

    <table class="table table-striped">
        <thead>
        <tr>
            @foreach (array_keys($authors[0]->toArray()) as $column)
                <th scope="col">
                    {{ $column }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($authors as $author)
            <tr>
                <td>
                    <a href="{{ route('author.edit', $author->author_id) }}">
                        {{ $author->author_id }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('author.show', $author->author_id) }}">
                        {{ $author->name }}
                    </a>
                </td>
                <td>{{ $author->created_at }}</td>
                <td>{{ $author->updated_at }}</td>
                <td>
                    @foreach($author->book as $book)
                        <a href="{{ route('book.show', $book->book_id) }}">
                            {{ $book->name }}
                        </a>,<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $authors->links() }}
@endsection

