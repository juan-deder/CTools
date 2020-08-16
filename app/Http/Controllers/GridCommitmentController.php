<?php

namespace App\Http\Controllers;

use App\Grid;
use Illuminate\Http\Request;

class GridCommitmentController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request, Grid $grid)
    {
        $grid->addCommitters($request['committers']);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, Grid $grid)
    {
        $grid->updateCommitterRoles($request->user_id, $request->roles);
    }

    public function destroy(Request $request, Grid $grid)
    {
        $grid->removeCommitters($request['committers']);
    }
}
