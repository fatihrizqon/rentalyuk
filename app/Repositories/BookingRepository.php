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
        return $this->booking->orderBy('created_at', 'desc')->sortable()->with(['user' => function($query){
            return $query->select('id', 'username');
        },'vehicle' => function($query){
            return $query->select('id', 'name');
        }])->paginate(10);
    }
    
    public function create($attributes){
        return $this->booking->create($attributes);
    }
    
    public function find($id){
        return $this->booking->findOrFail($id);
    }
    
    public function findByCode($code){
        return $this->booking->where('code', 'like', '%' . $code . '%')->with(['user' => function($query){ return $query->select('id', 'username');},'vehicle' => function($query){ return $query->select('id', 'name');}])->orderBy('created_at', 'desc')->sortable()->paginate(10);
    }

    public function findByDate($attributes)
    {
        return $this->booking->whereBetween('created_at', [$attributes['from'], $attributes['to']])->with(['user' => function($query){ return $query->select('id', 'username');},'vehicle' => function($query){ return $query->select('id', 'name');}])->orderBy('created_at', 'desc')->sortable()->paginate(10);
    }
    
    public function update($code, $attributes){
        return $this->booking->where('code' ,$code)->get()->first()->update($attributes);
    }
    
    public function delete($id){
        return $this->booking->findOrFail($id)->delete();
    }

    public function search($attributes)
    {
        return $this->booking->where($attributes)->where('status', 1)->get();
    }
}
