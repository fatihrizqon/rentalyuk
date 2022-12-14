<?php

namespace App\Repositories;

use App\Models\Vehicle;
use App\Repositories\BaseRepository;

class VehicleRepository implements BaseRepository{
    private $vehicle;
    
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function all(){
        return $this->vehicle->withCount(['bookings' => function($query){
            $query->where('status', 1);
        }])->get();
    }
    
    public function create($attributes){
        return $this->vehicle->create($attributes);
    }
    
    public function find($id){
        return $this->vehicle->findOrFail($id);
    }
    
    public function update($id, $attributes){
        return $this->vehicle->findOrFail($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->vehicle->findOrFail($id)->delete();
    }

    public function filter($attributes)
    {
        return $this->vehicle->filter($attributes)
                             ->orderBy('id', 'asc')
                             ->where('status', 1)
                             ->paginate(10)->withQueryString();
    }
}
