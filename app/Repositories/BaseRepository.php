<?php

namespace App\Repositories;

interface BaseRepository{
    public function all();
    
    public function create($attributes);
    
    public function find($id);
    
    public function update($id, $attributes);
    
    public function delete($id);
}
