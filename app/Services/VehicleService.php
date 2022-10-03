<?php
namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\VehicleRepository;

class VehicleService implements BaseService{

    protected $repository;

    public function __construct(VehicleRepository $repository)
    {
        $this->repository = $repository;
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
    
    public function update($id, array $attributes){
        return $this->repository->update($id, $attributes);
    }
    
    public function delete($id){
        return $this->repository->delete($id);
    }
    
}
