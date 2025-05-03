<?php

namespace App\Services\CRUDServices;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class BaseCRUDService
{
    protected Builder $query;
    public function __construct(public string $model)
    {
        $this->query = $this->model::query();
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }

    public function indexWithPaginate(array $params): LengthAwarePaginator
    {
        return $this->query->paginate($params['limit'] ?? 40);
    }
}
