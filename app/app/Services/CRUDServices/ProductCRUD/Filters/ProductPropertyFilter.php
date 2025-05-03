<?php

namespace App\Services\CRUDServices\ProductCRUD\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class ProductPropertyFilter
{
    public function handle(Builder $query, Closure $next)
    {
        $properties = request()->input('properties', []);

        foreach ($properties as $property => $values) {
            if (!is_array($values) || empty($values)) {
                continue;
            }

            $query->where(function ($q) use ($property, $values) {
                foreach ($values as $value) {
                    $q->orWhereJsonContains("properties->{$property}", $value);
                }
            });
        }

        return $next($query);
    }
}
