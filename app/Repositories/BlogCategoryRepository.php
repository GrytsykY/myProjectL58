<?php


namespace App\Repositories;


use App\Models\BlogCategory as Model;
use App\Models\BlogCategory;

/**
 * @package App\Models
 *
 * @property-read BlogCategory $parentCategory
 * @property-read string       $parentTitle
 */
class BlogCategoryRepository extends CoreRepository
{

    protected function getModelClass(){
        return Model::class;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getEdit($id){
        return $this->startConditions()->find($id);
    }

    /**
     * @return mixed
     */
    public function getForComboBox(){
        //return $this->startConditions()->all();

        $colums = implode(', ',[
            'id',
            'CONCAT (id,". ", title) AS id_title',
        ]);

//        $result[] = $this->startConditions()->all();
//        $result[] = $this
//            ->startConditions()
//            ->select('blog_categories.*',
//                DB::raw('CONCAT id,". ", title) AS id_title'))
//            ->toBase()
//            ->get();

        $result = $this
            ->startConditions()
            ->selectRaw($colums)
            ->toBase()
            ->get();
        return $result;
    }

    public function getAllWithPaginate($perPage = null){
        $colums = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($colums)
            ->with(['parentCategory:id,title',])
            ->paginate($perPage);
        return $result;
    }
}