<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_values';
    use HasFactory;

    protected $fillable = [
        'atribute_id',
        'value',
        'price'
    ];

    protected $casts = [
        'attribute_id' => 'integer'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
