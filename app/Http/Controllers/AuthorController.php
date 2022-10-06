<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use Illuminate\Contracts\Foundation\Application;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AuthorController extends CRUD_Controller
{
    const MODEL = 'Author';
    const RELATION = 'Book';

    /**
     * Store a newly created resource in storage.
     *
     * @param AuthorRequest $request
     * @return RedirectResponse|Redirector|Application
     */
    public function store(AuthorRequest $request): Redirector|RedirectResponse|Application
    {
        return parent::abstract_store($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AuthorRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(AuthorRequest $request, int $id): RedirectResponse
    {
        return parent::abstract_update($request, $id);
    }
}
