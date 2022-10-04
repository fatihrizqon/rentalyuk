<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Repositories\BookingRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Support\Facades\Session;

class BookingService implements BaseService{

    protected $repository;
    private $vehicle_repository;

    public function __construct(BookingRepository $repository, VehicleRepository $vehicle_repository)
    {
        $this->repository = $repository;
        $this->vehicle_repository = $vehicle_repository;
    }

    public function all(){
        return $this->repository->all();
    }

    public function filter($attributes)
    { 
        Session::forget('data');
        $vehicles = $this->vehicle_repository->filter($attributes);
        if(count($vehicles) == 0){
            return redirect('booking')->with('info', 'There is unavailable vehicle at the moment, please try another date.');
        }
        Session::put('data', [
            'from'     => Carbon::parse($attributes['from'])->minute(0)->second(0)->format('Y-m-d\TH:i'),
            'to'       => Carbon::parse($attributes['to'])->minute(0)->second(0)->format('Y-m-d\TH:i'),
            'duration' => $attributes['duration']
        ]);
        return $vehicles;

    }
    
    public function create($attributes){
        return $this->repository->create($attributes);
    }
    
    public function find($find){
        return $this->repository->find($find);
    }
    
    public function findByCode($code){
        return $this->repository->findByCode($code);
    }
    
    public function findByDate($attributes){
        return $this->repository->findByDate($attributes);
    }
    
    public function update($code, array $attributes){
        return $this->repository->update($code, $attributes);
    }
    
    public function delete($id){
        return $this->repository->delete($id);
    }
    
}
