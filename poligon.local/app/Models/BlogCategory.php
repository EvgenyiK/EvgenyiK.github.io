<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 * @package App\Models
 *
 * @property-read BlogCategory $parentCategory
 * @property-read string $parentTitle
 */
class BlogCategory extends Model
{
    use SoftDeletes;

    /**
     *ID корня
     */
    const ROOT = 1;

    protected $fillable
    =[
        'title',
          'slug',
          'parent_id',
         // 'description'
        ];

    /**
     * Получить родительскую категорию
     * @return BlogCategory
    */
    public function parentCategory(){
        return $this->belongsTo(BlogCategory::class,'parent_id','id');
    }

    /**
     * Пример аксессуара (Accessor)
     * @return string
     */

    public function getParentTitleAttribute()
    {
        $title = $this->parentCategory->title
            ??($this->isRoot()
            ?'Корень'
            :'???');

        return $title;
    }

    public function isRoot(){
        return $this->id === BlogCategory::ROOT;
    }

    /**
     * Пример аксессуара (Accessor)
     * @return string $valueFromObject
     */

    public function getTitleAttribute($valueFromObject){
        return mb_strtoupper($valueFromObject);
    }

    /**
     * Пример мутатора
     * @return string $incomingValue
     */

    public function setTitleAttribute($incomingValue)
    {
        $this->attributes['title'] = mb_strtolower($incomingValue);
    }
}
