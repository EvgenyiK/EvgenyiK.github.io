<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    const UNKNOWN_USER = 1;

    protected $fillable
        =[
            'title',
            'slug',
            'category_id',
            'except',
            'content_raw',
            'is_published',
            'published_at',
        ];
    /**
     * Категория статьи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo;
    */
    public function category(){
        //стаья принадлежит категории
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Автор статьи
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo;
     */
    public function user(){
        //стаья принадлежит категории
        return $this->belongsTo(User::class);
    }
}
