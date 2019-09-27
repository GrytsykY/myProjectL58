<?php


namespace App\Repositories;


use App\Models\BlogPost as Model;

class BlogPostRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return mixed
     */
    public function getAllWithPaginate(){
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id','DESC')
            ->with([
                'category:id,title',
                'user:id,name'
            ])
            ->paginate(25);

        return $result;
    }

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

    /**
     * @param $id
     * @return Model
     */
    public function getEdit($id){
        return $this->startConditions()->find($id);
    }
}