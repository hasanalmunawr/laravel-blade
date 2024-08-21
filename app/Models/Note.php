<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $id)
 */
class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'created_by'
    ];
}
