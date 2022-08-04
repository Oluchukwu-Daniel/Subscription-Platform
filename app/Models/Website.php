<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url'
    ];

    public function posts()
    {
        return $this->hasMany(Posts::class);
    }

    public function subscription()
    {
        return $this->hasMany(User_Subscription::class);
    }
}
