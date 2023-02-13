<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use HasFactory,softDeletes;
    
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'image',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'is_featured',
        'status',
        'order_by',
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class,'id','parent_id');
    }
    public function user()
    {
        return $this->hasMany(User::class,'id','parent_id');
    }
    
}

