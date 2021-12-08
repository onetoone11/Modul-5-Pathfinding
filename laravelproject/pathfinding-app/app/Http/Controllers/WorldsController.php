<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\World;
use DB;

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
        // $data = DB::select(DB::raw('SELECT * FROM `worlds`'));
        
        $world = new World;
        $world->name = $this->generateRandomName();
        $world->type = $request->input('worldType');
        $world->save();
        
        return redirect('load');
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
        $type = DB::select("SELECT type FROM worlds WHERE id=$id");
        $rooms = DB::select("SELECT rooms.id, rooms.exits FROM rooms INNER JOIN worlds ON rooms.world_id=worlds.id");

        return view('pages.canvas')->with('rooms', $rooms)->with('type', $type);
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
