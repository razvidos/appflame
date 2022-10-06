<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class BookController extends CRUD_Controller
{
    const MODEL = 'Book';
    const RELATION = 'Author';

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(BookRequest $request): Redirector|RedirectResponse|Application
    {
        return parent::abstract_store($request);
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
        return parent::abstract_update($request, $id);
    }
}
