<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PriceMonitoring;

use Carbon\Carbon;

class PriceMonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $price_monitoring = PriceMonitoring::orderBy('created_at','DESC')
        ->get();
        return view('price_monitoring.index',[
            'price_monitoring' => $price_monitoring
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('price_monitoring.create');
    }

    public function save_update($request = []){
        $price_monitoring = PriceMonitoring::find($request->id);
        if(empty($price_monitoring)){
            $price_monitoring = new PriceMonitoring;
        }

        $price_monitoring->created_by_user_id = Auth::user()->id;
        $price_monitoring->commodities_item = $request->commodities_item;
        $price_monitoring->commodities_type = $request->commodities_type;
        $price_monitoring->commodities_size = $request->commodities_size;
        $price_monitoring->price = $request->price;
        $price_monitoring->attachment = $request->attachment;
        $price_monitoring->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->save_update($request);
        return redirect()->route('price_monitorings')->withStatus(__('Price Monitoring successfully created.'));
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
    public function edit(PriceMonitoring $price_monitoring)
    {
        return view('price_monitoring.edit',[
            'price_monitoring' => $price_monitoring
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $this->save_update($request);
        return redirect()->route('price_monitorings')->withStatus(__('Price Monitoring successfully updated.'));
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
