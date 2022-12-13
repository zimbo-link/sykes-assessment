<?php

namespace App\Http\Controllers;
 
use App\Models\Properties;
use Illuminate\Http\Request;


class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $token = $request->get("_token");
        $search = $request->get("search");
        $from = $request->get("from");
        $to = $request->get("to");
        $near_beach = $request->get("near_beach") == "on" ? 1 : 0;
        if(!isset($near_beach)){
            $near_beach = 0;
        }
        $accepts_pets = $request->get("accepts_pets") == "on" ? 1 : 0;
        if(!isset($accepts_pets)){
            $accepts_pets = 0;
        }

        $sleeps = $request->get("sleeps");
        if(!isset($sleeps)){
            $sleeps = 0;
        }
        $beds = $request->get("beds");
        if(!isset($beds)){
            $beds = 0;
        }
        if(!isset($token)){
            $properties = Properties::with('location', 'bookings') 
                        ->whereHas('location', function($q) use($search) {
                            $q->where('location_name', 'like', "%".$search."%");
                        })->get();
        } else {
            $properties = Properties::where('near_beach', $near_beach)
                        ->where('accepts_pets', $accepts_pets)
                        ->where('sleeps', '>', $sleeps)
                        ->where('beds', '>', $beds)
                        ->with('location', 'bookings') 
                        ->whereHas('location', function($q) use($search) {
                            $q->where('location_name', 'like', "%".$search."%");
                        })->get();
        }
            

        
        $available_ids = [];

        if(isset($from) && isset($to)){
            foreach($properties as $property){
                $available = true;
                foreach($property->bookings as $booking){
                    if( ($booking->start_date >= $from && $booking->start_date <= $to) || ($booking->end_date >= $from && $booking->end_date <= $to) ){
                        $available = false;
                    }
                }
                if($available) { 
                    $available_ids[] = $property->id;
                }
            }
        } else {
            $available_ids = collect($properties)->pluck('id')->toArray();
        }

        $available_properties = Properties::whereIn('id', $available_ids )->paginate(5);
    
        return view('properties', compact(['available_properties', 'search', 'from', 'to', 'near_beach', 'accepts_pets', 'sleeps', 'beds']));
    }

     
}
