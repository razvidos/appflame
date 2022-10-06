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
        $model_class = self::getModelClass(static::MODEL);
        $relation_name = mb_strtolower(static::RELATION);

        $elements = ($model_class)::with($relation_name)->paginate(15);

        $route_name = mb_strtolower(static::MODEL . '.index');
        return view($route_name)->with(compact('elements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $relation_class = self::getModelClass(static::RELATION);
        $primary_key = mb_strtolower(static::RELATION . '_id');

        $relations = ($relation_class)::all([$primary_key, 'name']);

        $route_name = mb_strtolower(static::MODEL . '.create');
        return view($route_name)->with(compact('relations'));
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

        $model_class = self::getModelClass(static::MODEL);
        $relation_name = mb_strtolower(static::RELATION);

        $relation_ids = $validated[$relation_name . "s"];
        unset($validated[$relation_name]);

        $element = ($model_class)::create($validated);
        $element->$relation_name()->sync($relation_ids);

        $model_name = mb_strtolower(static::MODEL);
        $route_name = $model_name . '.show';
        $primary_key = $model_name . '_id';
        return redirect(route($route_name, $element->$primary_key));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id): View|Factory|Application
    {
        $model_name = self::getModelClass(static::MODEL);
        $relation_name = mb_strtolower(static::RELATION);

        $element = ($model_name)::with($relation_name)->find($id);

        $route_name = static::MODEL . '.show';
        return view($route_name)->with(compact('element'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $relation_name = mb_strtolower(static::RELATION);
        $relation_primary_key = $relation_name . '_id';
        $model_class = self::getModelClass(static::MODEL);
        $relation_class = self::getModelClass(static::RELATION);

        $element = ($model_class)::with($relation_name)->find($id);
        $element_relation_ids = $element->$relation_name->pluck($relation_primary_key);
        $relations = ($relation_class)::all([$relation_primary_key, 'name']);

        $route_name = mb_strtolower(static::MODEL. '.edit');
        return view($route_name)
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

        $model_class = self::getModelClass(static::MODEL);
        $relation_name = mb_strtolower(static::RELATION);

        $relation_ids = $validated[$relation_name. 's'];
        unset($validated[$relation_name . 's']);

        $element = ($model_class)::find($id);
        $element->update($validated);
        $element->$relation_name()->sync($relation_ids);

        $route_name = mb_strtolower(static::MODEL . '.show');
        return redirect(route($route_name, $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $model_class = self::getModelClass(static::MODEL);
        $element = ($model_class)::find($id);
        $element->delete();

        $route_name = mb_strtolower(static::MODEL . '.index');
        return redirect(route($route_name));
    }
}
