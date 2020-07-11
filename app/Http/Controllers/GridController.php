<?php

namespace App\Http\Controllers;

use App\Grid;
use App\Http\Requests\SaveGrid;
use App\Http\Resources\GridResource;

class GridController extends Controller
{
    public function index()
    {
        return GridResource::collection(request()->user()->grids);
    }

    public function store(SaveGrid $request)
    {
        $grid = Grid::create($request->except('committers'))->refresh(); // get active field

        $grid->addCommitters($request->committers + [$request->user()->id => ['roles' => 'owner']]);

        return $this->show($grid);
    }

    public function show(Grid $grid)
    {
        return new GridResource($grid);
    }

    public function update(SaveGrid $request, Grid $grid)
    {
        $grid->update($request->except('committers'));

        if ($committers = $request->committers)
            $grid->committers()->sync($committers + [$request->user()->id => ['roles' => 'owner']]);

        return $this->show($grid);
    }

    public function destroy(Grid $grid)
    {
        $grid->delete();
    }
}
