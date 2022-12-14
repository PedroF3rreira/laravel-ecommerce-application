<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * @var
     */
    protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'description', 'parent_id', 'featured', 'menu', 'image'];

    protected $casts = [
        'parent_id' => 'integer',
        'featured' => 'boolean',
        'menu' => 'boolean'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * categoria pertence a apenas um pai
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * categoria pai tem varios filhos
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
