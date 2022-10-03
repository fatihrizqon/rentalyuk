<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\BaseRepository;

class BookingRepository implements BaseRepository{
    private $booking;
    
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function all(){
        return $this->booking->all();
    }
    
    public function create($attributes){
        return $this->booking->create($attributes);
    }
    
    public function find($id){
        return $this->booking->findOrFail($id);
    }
    
    public function update($id, $attributes){
        return $this->booking->findOrFail($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->booking->findOrFail($id)->delete();
    }
}
