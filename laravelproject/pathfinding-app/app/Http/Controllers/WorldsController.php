<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\World;

class WorldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = DB::select(DB::raw('SELECT * FROM `worlds`'));
        
        $world = new World;
        $world->name = $this->generateRandomName();
        $world->type = $request->input('worldType');
        $world->save();
        back();
        return redirect('load')->with('data', $data);
    }

    function generateRandomName() {
        
        $vowels = 'aoueiy';
        $consonants = 'bdfghklmnprstv';

        $length = rand(4,10);

        $randomName = '';

        while($length > 0){
            if($length-- %2 == 0) {
                $randomName .= $consonants[rand(0,13)];
            } else {
                $randomName .= $vowels[rand(0,5)];
            }
        };

       
        
        return $randomName;
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
        return view('pages.create');
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

    public function showAllWorlds() {
        $data = DB::select(DB::raw('SELECT * FROM `worlds`'));
        return view('pages.load')->with('data', $data);
    }

    
}
