<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Pipeline;

trait PipelineFilterTrait
{
    public function indexWithPaginate(array $params): LengthAwarePaginator
    {
        Pipeline::send($this->query)->pipe($this->getFilters())->thenReturn();

        return parent::indexWithPaginate($params);
    }

    abstract public function getFilters(): array;
}