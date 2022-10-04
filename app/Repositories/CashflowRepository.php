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
        return $this->cashflow->orderBy('created_at', 'desc')->sortable()->paginate(10);
    }
    
    public function create($attributes){
        return $this->cashflow->create($attributes);
    }
    
    public function find($id){
        return $this->cashflow->findOrFail($id);
    }
    
    public function findByCode($code){
        return $this->cashflow->where('code', 'like', '%' . $code . '%')->sortable()->paginate(10);
    }

    public function findByDate($attributes)
    {
        return $this->cashflow->whereBetween('created_at', [$attributes['from'], $attributes['to']])->sortable()->paginate(10);
    }
    
    public function update($id, $attributes){
        return $this->cashflow->findOrFail($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->cashflow->findOrFail($id)->delete();
    }
}
