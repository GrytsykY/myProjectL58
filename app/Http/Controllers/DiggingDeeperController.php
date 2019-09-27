<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiggingDeeperController extends Controller
{
    public function collections(){
        $result = [];

        $eloquentCollection = BlogPost::withTrashed()->get();
        //dd(__METHOD__,$eloquentCollection, $eloquentCollection->toArray());

        $collection = collect($eloquentCollection->toArray());

//        dd(
//            get_class($eloquentCollection),
//            get_class($collection),
//            $collection
//        );
//        $result['first'] = $collection->first();
//        $result['last'] = $collection->last();

//        $result['where']['data'] = $collection
//            ->where('category_id',10)
//            ->values()
//            ->keyBy('id');
        //dd($result);

        /**
         * проверяем  наличие коллекции
         */
//        if ($result['where']['data']->isNotEmpty){
//            //.....
//        }

        /**
         * Базовая переменная не изменится. Просто вернутся измененная версия
         */
        $result['map']['all'] = $collection->map(function (array $item){
            //dd($item);
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);

            return $newItem;
        });

//        $result['map']['not_exists'] = $result['map']['all']
//            ->where('exists','=',false)
//            ->values()
//            ->keyBy('item_id');
//
//        dd($result);
        /**
         * Фильтрация. Замена orWhere()
         */
        $filtered = $collection->filter(function ($item){
            $byDay = $item->created_at->isFriday();
            $byDate = $item->created_at->day == 13;

            $result = $byDate;

            return $result;
        });

        dd(compact('filtered'));
    }
}
