<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
Базовая информация
 * @url https://laravel.com/docs/5.8/collections
 */
class DiggingDeeperController extends Controller
{
   public function collections()
   {
       $result = [];

       /**
        * @url \Illuminate\Support\Collection $eloquentCollection
        */
       $eloquentCollection = BlogPost::withTrashed()->get();
       //dd(__METHOD__,$eloquentCollection,$eloquentCollection->toArray());
       /**
        * @url \Illuminate\Support\Collection $collection
        */
       $collection = collect($eloquentCollection->toArray());
       //$result['first'] = $collection->first();
      // $result['last'] = $collection->last();
       //выборка из коллекции
       $result['where']['data'] = $collection
           ->where('category_id',10)
           ->values()
           ->keyBy('id');
      //Базовая переменная не изменится. Просто вернется измененная версия
       $result['map']['all'] = $collection->map(function (array $item){
           $newItem = new \stdClass();
           $newItem->item_id = $item['id'];
           $newItem->item_name = $item['title'];
           $newItem->exists = $item['deleted_at'];

           return $newItem;
       });

       $result['map']['not_exists']=$result['map']['all']
           ->where('exists','=',false)
           ->values()
           ->keyBy('item_id');
       dd($result);
   }
}
