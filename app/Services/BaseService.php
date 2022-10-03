<?php

namespace App\Services;
interface BaseService{
    public function all();
    
    public function create($attributes);
    
    public function find($id);
    
    public function update($id, array $attributes);
    
    public function delete($id);
}
