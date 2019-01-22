<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\User;

class Todo extends Model
{
    use Searchable;

    public function searchableAs()
    {
        return 'todo';
    }

    protected $fillable = [
        'todo'
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }
}
