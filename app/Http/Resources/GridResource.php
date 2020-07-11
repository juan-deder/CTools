<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class GridResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $grid = Arr::except(parent::toArray($request), 'commitment');

        $committers = $this->resource->committers->toArray();
        $committers = array_map(fn($committer) =>
            Arr::except($committer, 'commitment') + ['roles' => $committer['commitment']['roles']], $committers);

        return $grid + ['count' => count($committers), 'committers' => $committers];
    }
}
