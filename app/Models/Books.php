<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = ['name', 'writer_id', 'description', 'image'];

    /**
     * @method write()
     * get book writer
     * @return object
     */
    public function write()
    {
        return $this->belongsTo(Writer::class, 'writer_id', 'id');
    }
}
