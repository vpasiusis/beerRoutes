<?php

namespace App\Http\Controllers;

use App\Beer;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Classes\Distances;
use App\Classes\Breweries;
use App\Classes\Location;
use App\Classes\Route;

class BeersController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($startLocation)
    {
        $start = microtime(true);
        $distances = new Distances();
        $breweries = new Breweries();
        $route = new Route();
        $geoCodes=DB::table('geocodes')->get();
        $beers = Beer::all();
        $breweriesArray=$breweries->FormingDraweries($beers,$geoCodes);
        $geoCodes=$distances->removeUnusedBreweries($geoCodes,$breweriesArray);
        $distanceMatrix=$distances->FormingMatrix($geoCodes);
        $firstBrewery=$distances->FirstPosibleBrewery($geoCodes,$startLocation->latitude,$startLocation->longitude);
        $newgeoCodes=$distances->formGeoCodes($geoCodes);
        $newgeoCodes;
        $niekas=$route->Routes($distanceMatrix,$breweriesArray,$firstBrewery,$startLocation,$newgeoCodes);
        $time=microtime(true)-$start;
        dump($time);
        dump($niekas);
       # return view('beer.index', ['beers' => $beers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'], 
            'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);
        
        if ($validator->fails()) {
            return redirect('/')->with('success','Post Created');
        } else {
           $this->index(new Location($request->input('latitude'),$request->input('longitude')));
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}