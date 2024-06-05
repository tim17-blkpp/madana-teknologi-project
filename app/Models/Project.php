<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $fillable = ['category_id', 'client_id', 'name', 'description', 'url', 'thumbnail_path', 'start_date', 'end_date', 'status', 'show_on_landing_page'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    // public function thumbnail()
    // {
    //     return $this->belongsTo(Gallery::class, 'thumbnail_id');
    // }
}
