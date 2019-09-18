<?php

namespace App\Observers;

use App\Http\Requests\BlogPostUpdateRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostObserver
{
    /**

     * Отработка перед созданием записи
     * @param BlogPost $blogPost
     */
    public function creating(BlogPost $blogPost){
       $this->setPublishedAt($blogPost);
       $this->setSlug($blogPost);
       $this->setUser($blogPost);
       $this->setHtml($blogPost);
    }

    /**
     * Отработка перед созданием записи
     * @param BlogPost $blogPost
     */
    public function updating(BlogPost $blogPost){
     $test[]= $blogPost->isDirty();
        $test[]= $blogPost->isDirty('is_published');
        $test[]= $blogPost->isDirty('user_id');
        $test[]= $blogPost->getAttribute('is_published');
        $test[]= $blogPost->is_published;
        $test[]= $blogPost->getOriginal('is_published');
        dd($test);


     $this->setPublishedAt($blogPost);
     $this->setSlug($blogPost);
    }

    /**
     * Если дата публикации не установлена и происходит установка флага - Опубликовано,
     * то устанавливаем дату публикации на текущую.
     * @param BlogPost $blogPost
     */
    protected function setPublishedAt(BlogPost $blogPost){
        $needSetPublished = empty($blogPost->published_at) && $blogPost->is_published;
        if ($needSetPublished){
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     * Если дата публикации не установлена и происходит установка флага - Опубликовано,
     * то устанавливаем дату публикации на текущую.
     * @param BlogPost $blogPost
     */
    protected function setSlug(BlogPost $blogPost){
        if (empty($blogPost->slug) && $blogPost->is_published){
            $blogPost->slug = \Str::slug($blogPost->title);
        }
    }

    protected function setHtml(BlogPost $blogPost){
        if ($blogPost->isDirty('content_raw')){
            // TODO: Тут должна быть генерация markdown ->html
            $blogPost->content_html = $blogPost->content_raw;
        };
    }

    /**
     * Если дата публикации не установлена и происходит установка флага - Опубликовано,
     * то устанавливаем дату публикации на текущую.
     * @param BlogPost $blogPost
     */
    protected function setUser(BlogPost $blogPost){
        if ($blogPost->isDirty('content_raw')){
            $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;
        };
    }

    /**
     * @param \App\Models\BlogCategory $blogCategory
     * @return void
     */
    public function created(BlogCategory $blogPost){

    }

    /**
     * @param \App\Models\BlogCategory $blogCategory
     * @return void
     */
    public function updated(BlogPostUpdateRequest $request,$id){

    }

    /**
     * @param \App\Models\BlogPost $blogPost
     * @return void
     */
    public function deleting(BlogPost $blogPost){
        //dd(__METHOD__,$blogPost);
        //return false;
    }
    /**
     * @param \App\Models\BlogPost $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost){
        //dd(__METHOD__,$blogPost);
    }

    /**
     * @param \App\Models\BlogCategory $blogCategory
     * @return void
     */
    public function restored(BlogCategory $blogPost){

    }

    /**
     * @param \App\Models\BlogCategory $blogCategory
     * @return void
     */
    public function forceDeleted(BlogCategory $blogPost){

    }

}
