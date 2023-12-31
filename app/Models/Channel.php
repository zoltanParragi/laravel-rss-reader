<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Newsitem;

class Channel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'channel_name',
        'url',
        'news',
    ];
    
    public function get_news() {
        return $this->hasMany(Newsitem::class);
    }
}
