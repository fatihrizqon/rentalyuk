<?php
namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\CashflowRepository;

class CashflowService implements BaseService{

    protected $repository;

    public function __construct(CashflowRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index($attributes)
    {
        $attributes = [
            'from' => $attributes['from'] ?? '',
            'to' => $attributes['to'] ?? '',
            'keywords' => $attributes['keywords'] ?? '',
        ];
        
        if($attributes['from'] && $attributes['to']){
            return $this->findByDate($attributes);
        }elseif($attributes['keywords']){
            return $this->findByCode($attributes['keywords']);
        }else{
            return $this->all();
        }
    }

    public function all(){
        return $this->repository->all();
    }
    
    public function create($attributes){
        return $this->repository->create($attributes);
    }
    
    public function find($id){
        return $this->repository->find($id);
    }
    
    public function findByCode($code){
        return $this->repository->findByCode($code);
    }
    
    public function findByDate($attributes){
        return $this->repository->findByDate($attributes);
    }
    
    public function update($id, array $attributes){
        return $this->repository->update($id, $attributes);
    }
    
    public function delete($id){
        return $this->repository->delete($id);
    }
    
}
