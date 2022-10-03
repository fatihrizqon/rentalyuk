<?php

namespace App\Repositories;

use App\Models\Cashflow;
use App\Repositories\BaseRepository;

class CashflowRepository implements BaseRepository{
    private $cashflow;
    
    public function __construct(Cashflow $cashflow)
    {
        $this->cashflow = $cashflow;
    }

    public function all(){
        return $this->cashflow->all();
    }
    
    public function create($attributes){
        return $this->cashflow->create($attributes);
    }
    
    public function find($id){
        return $this->cashflow->findOrFail($id);
    }
    
    public function update($id, $attributes){
        return $this->cashflow->findOrFail($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->cashflow->findOrFail($id)->delete();
    }
}
