<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testGridCommitments()
    {
        $grid = factory('App\Grid')->states('with_committers')->create();

    }
}
