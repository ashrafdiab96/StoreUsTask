<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    use HasFactory;
    protected $table = 'writer';
    protected $fillable = ['name', 'brief'];

    /**
     * @method books()
     * get writer books
     * @return array[object]
     */
    public function books()
    {
        return $this->hasMany(Books::class);
    }
}
