<?php

namespace Tests\Feature;

use App\Grid;
use App\User;
use Tests\TestCase;

class GridsTest extends TestCase
{
    public function test_creating_and_updating()
    {
        $this->actingAs($user = factory(User::class)->create());
        $gridSample = factory(Grid::class)->make();

        // Create grid
        $this->post('api/grids', $gridSample->toArray())->assertCreated();
        $grid = Grid::first();
        $this->assertDatabaseHas('grids', $gridSample->toArray())
            ->assertDatabaseHas('grid_commitments', ['user_id' => $user->id, 'grid_id' => $grid->id, 'roles' => 'owner']);

        // Update grid
        $this->put("api/grids/$grid->id", $newGrid = ['name' => 'Renamed', 'active' => false])
            ->assertOk();
        $this->assertDatabaseHas('grids', $newGrid);
    }

    public function test_fetching()
    {
        $grids = factory(Grid::class, 2)->create();
        $committers = ['1' => ['roles' => 'owner'], '2' => ['roles' => 'approver,editor']];
        $users = factory(User::class, 2)->create();

        $grids->each(fn ($grid) => $grid->addCommitters($committers));

        $this->actingAs($owner = User::first())->get('api/grids')->assertOk()
            ->assertJson($grids->map(fn ($grid) => $grid->toArray() +
                ['committers' => array_map(fn ($committer, $id) => ['id' => $id]  + $committer, $committers, array_keys($committers))])->toArray());
    }

    public function test_commitments()
    {
        $this->actingAs($user = factory(User::class)->create());
        $assistants = factory(User::class, 2)->create();
        $grid = factory(Grid::class)->create();
        $grid->addCommitters([$user->id => ['roles' => 'owner']]);

        // Create commitment
        $commitments = $assistants->pluck('id')->combine([['roles' => 'editor'], ['roles' => 'approver']])->all();
        $this->post("api/commitments/$grid->id", ['committers' => $commitments])
            ->assertOk();

        array_walk($commitments, fn ($commitment, $user_id) => $this->assertDatabaseHas('grid_commitments',
            ['grid_id' => $grid->id, 'user_id' => $user_id, 'roles' => $commitment['roles']]));

        // Update committer roles
        $committer = ['user_id' => $assistants->first()->id, 'roles' => 'observer'];
        $this->put("api/commitments/$grid->id", $committer)->assertOk();
        $this->assertDatabaseHas('grid_commitments', $committer);

        $commitment = $grid->committers->first()->commitment;
        $this->delete("api/commitments/$grid->id", ['committers' => $commitment->user_id])->assertOk();
        $this->assertDatabaseMissing('grid_commitments', $commitment->toArray());
    }

    public function unauthorized_users_cant_manage()
    {

    }
}
