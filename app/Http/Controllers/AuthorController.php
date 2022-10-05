<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $authors = Author::with('book')->paginate(15);
        return view('author.index')->with(compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $books = Book::all(['book_id', 'name']);
        return view('author.create')->with(compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AuthorRequest $request
     * @return RedirectResponse|Redirector|Application
     */
    public function store(AuthorRequest $request): Application|RedirectResponse|Redirector
    {
        $validated = $request->validated();
        $book_ids = $validated['books'];
        unset($validated['books']);
        $author = Author::create($validated);
        $author->book()->sync($book_ids);
        return redirect(route('author.show', $author->author_id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id): View|Factory|Application
    {
        $author = Author::with('book')->find($id);
        return view('author.show')->with(compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $author = Author::with('book')->find($id);
        $author_book_ids = $author->book->pluck('book_id');
        $books = Book::all(['book_id', 'name']);
        return view('author.edit')->with(compact('author', 'books', 'author_book_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AuthorRequest $request
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function update(AuthorRequest $request, int $id): Application|RedirectResponse|Redirector
    {
        $validated = $request->validated();
        $book_ids = $validated['books'];
        unset($validated['books']);

        $author = Author::find($id);
        $author->update($validated);
        $author->book()->sync($book_ids);

        return redirect(route('author.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Author $author
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Author $author): Redirector|RedirectResponse|Application
    {
        $author->delete();
        return redirect(route('author.index'));
    }
}
