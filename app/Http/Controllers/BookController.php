<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $books = Book::with('author')->paginate(15);
        return view('book.index')->with(compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $authors = Author::all(['author_id', 'name']);
        return view('book.create')->with(compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BookRequest $request): Redirector|RedirectResponse|Application
    {
        $validated = $request->validated();
        $author_ids = $validated['authors'];
        unset($validated['authors']);
        $book = Book::create($validated);
        $book->author()->sync($author_ids);
        return redirect(route('book.show', $book->book_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id): View|Factory|Application
    {
        $book = Book::with('author')->find($id);
        return view('book.show')->with(compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $book = Book::with('author')->find($id);
        $book_author_ids = $book->author->pluck('author_id');
        $authors = Author::all(['author_id', 'name']);
        return view('book.edit')->with(compact('book', 'authors', 'book_author_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BookRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $author_ids = $validated['authors'];
        unset($validated['authors']);

        $book = Book::find($id);
        $book->update($validated);
        $book->author()->sync($author_ids);

        return redirect(route('book.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Book $book): Redirector|RedirectResponse|Application
    {
        $book->delete();
        return redirect(route('book.index'));
    }
}
