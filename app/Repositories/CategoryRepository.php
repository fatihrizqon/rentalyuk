<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository implements BaseRepository{
    private $category;
    
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function all(){
        return $this->category->all();
    }
    
    public function create($attributes){
        return $this->category->create($attributes);
    }
    
    public function find($id){
        return $this->category->findOrFail($id);
    }
    
    public function update($id, $attributes){
        return $this->category->findOrFail($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->category->findOrFail($id)->delete();
    }
}
