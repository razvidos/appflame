<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

abstract class CRUD_Controller extends Controller
{
    const MODEL = 'MODEL';
    const RELATION = 'RELATION';

    protected static function getModelClass(string $model): string
    {
        return 'App\\Models\\' . $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $elements = self::getModelClass(static::MODEL)
            ::with(mb_strtolower(static::RELATION))
            ->paginate(15);
        return view(mb_strtolower(static::MODEL . '.index'))->with(compact('elements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $relations = self::getModelClass(static::RELATION)
            ::all([mb_strtolower(static::RELATION . '_id'), 'name']);
        return view(mb_strtolower(static::MODEL . '.create'))
            ->with(compact('relations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function abstract_store(FormRequest $request): Redirector|RedirectResponse|Application
    {
        $validated = $request->validated();
        $relation_ids = $validated[mb_strtolower(static::RELATION) . "s"];
        unset($validated[mb_strtolower(static::RELATION)]);
        $element = self::getModelClass(static::MODEL)::create($validated);
        $relation = mb_strtolower(static::RELATION);
        $element->$relation()->sync($relation_ids);
        $primary_key = mb_strtolower(static::MODEL . '_id');
        return redirect(route(mb_strtolower(static::MODEL . '.show'), $element->$primary_key));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id): View|Factory|Application
    {
        $element = self::getModelClass(static::MODEL)::with(mb_strtolower(static::RELATION))->find($id);
        return view(static::MODEL . '.show')->with(compact('element'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $element = self::getModelClass(static::MODEL)::with(mb_strtolower(static::RELATION))->find($id);
        $relation = mb_strtolower(static::RELATION);
        $element_relation_ids = $element->$relation->pluck(mb_strtolower(static::RELATION . '_id'));
        $relations = (self::getModelClass(static::RELATION))::all([mb_strtolower(static::RELATION . '_id'), 'name']);
        return view(mb_strtolower(static::MODEL. '.edit'))
            ->with(compact('element', 'relations', 'element_relation_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormRequest $request
     * @param int $id
     * @return RedirectResponse|Redirector|Application
     */
    public function abstract_update(FormRequest $request, int $id): Application|RedirectResponse|Redirector
    {
        $validated = $request->validated();
        $relation_ids = $validated[mb_strtolower(static::RELATION . 's')];
        unset($validated[mb_strtolower(static::RELATION. 's')]);

        $element = self::getModelClass(static::MODEL)::find($id);
        $element->update($validated);
        $relation = mb_strtolower(static::RELATION);
        $element->$relation()->sync($relation_ids);

        return redirect(route(mb_strtolower(static::MODEL . '.show'), $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $element = self::getModelClass(static::MODEL)::find($id);
        $element->delete();
        return redirect(route(mb_strtolower(static::MODEL . '.index')));
    }
}
