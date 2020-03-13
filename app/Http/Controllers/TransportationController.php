<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transportation;

class TransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("backend.transportation.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.type.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "transportation_type" => "required|min:3|max:10",
            'transportation_image' => '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $transportation_image = $request->file('transportation_image');
        if($transportation_image){
            $name=uniqid().time().'.'.$transportation_image->getClientOriginalExtension();
            $transportation_image->move(public_path('image/transportation'),$name);
            $path='image/transportation/'.$name;
        }
        else if ($transportation_image == null) {
            $path = $request->transportation_old_image;
        }

        Transportation::Create([
            'transportation_type' => $request->transportation_type,
            'transportation_image' => $path
        ]);        
   
        return response()->json(['success'=>'Transportation saved successfully.']);
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
        $type = Transportation::find($id);
        return $type;
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
        $request->validate([
            "edit_transportation_type" => "required|min:3|max:10",
            'edit_transportation_image' => '|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $transportation_image = $request->file('edit_transportation_image');
        if($transportation_image){
            $name=uniqid().time().'.'.$transportation_image->getClientOriginalExtension();
            $transportation_image->move(public_path('image/transportation'),$name);
            $path='image/transportation/'.$name;
        }
        else if ($transportation_image == null) {
            $path = $request->transportation_old_image;
        }
        $transportation_id = $request->edit_transportation_id;
        $transportation= Transportation::find($transportation_id);
        $transportation->transportation_type=$request->edit_transportation_type;
        $transportation->transportation_image=$path;
        $transportation->save();
        return response()->json(['success'=>'Transportation saved successfully.']);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Transportation::find($id);
        $type->delete();
        return response()->json(['success'=>'Transportation deleted successfully.']);
    }

    public function getTransportations(Request $request)
    {
        $types = Transportation::all();
        return $types;
    }
}
