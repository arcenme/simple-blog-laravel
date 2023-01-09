<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, Blameable;
    protected $guarded = ['id'];

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
