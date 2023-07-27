<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
    ];

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = strtolower($value);

        return $this;
    }
}
