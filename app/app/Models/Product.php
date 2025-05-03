<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $count
 * @property array $properties
 */
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'price',
        'count',
        'properties'
    ];

    protected $casts = [
        'properties' => 'array'
    ];
}
