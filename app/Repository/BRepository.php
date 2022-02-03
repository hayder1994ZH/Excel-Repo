<?php
namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

//                        <----------- Welcome To BaseRepository Page ----------->

abstract class BRepository {

    public $table;
    public function __construct(Model $model){
        $this->table = $model;
    }
    
    //Base repo to get item by id
    public function getById($id){
        $model = $this->table->where('is_deleted', 0)->findOrFail($id);
        return  $response = ['message' => $model,'code' => 200];
    }

    //Base repo to create item
    public function create($data){
        
        $model = $this->table->create($data);
        return  $response = ['message' => $model,'code' => 200];
    }

    //Base repo to update item 
    public function update($id, $values){
        $item = $this->table->where('is_deleted', 0)->where('id',$id)->firstOrFail();
        $item->update($values);
        return  $response = ['message' => 'Updated successfuly','code' => 200];
    }

    //base repo to delete item
    public function softDelete($model)
    {
        $model->update(['is_deleted' => 1]);
        return  $response = ['message' => 'deleted successfuly','code' => 200];
    }

}
