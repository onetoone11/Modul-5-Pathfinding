<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\World;
use App\Models\Room;
use DB;

class WorldsController extends Controller {
    
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

        $type = $request->input('worldType');
        $worldSize = $request->input('worldSize');

        $param2 = $request->input('param2');

        $world = new World;
        $world->name = $request->input('worldName');
        $world->type = $type;
        $world->param1 = $worldSize;
        $world->param2 = $param2;
        $world->save();
        

        // $roomArray = array();


        //helper functions
        //--------------------------------------------------------------------------------------------------------
        function modulo( $dividend, $divisor ){
            return ( $dividend % $divisor + $divisor ) % $divisor;
        }

        function to1D($x, $y, $rowlength) {
            return ($y * $rowlength) + $x;
        }
        //--------------------------------------------------------------------------------------------------------


        //name generation
        //--------------------------------------------------------------------------------------------------------
        
        
        function names() {
            $adjective = array(
                "big",
                "colossal",
                "fat",
                "gigantic",
                "great",
                "huge",
                "immense",
                "large",
                "microscopic",
                "teeny"
            );
            
            $location = array(
                "hallway",
                "corridor",
                "dungeon",
                "cave",
                "church",
                "swamp",
                "lake",
                "graveyard",
                "bush",
                "school"
            );
            
            $abstractnoun = array(
                "disquiet",
                "poverty",
                "failure",
                "stupidity",
                "weakness",
                "rhythm",
                "relaxation",
                "strength",
                "sorrow",
                "birthday"
            );

            return "A ".$adjective[array_rand($adjective)]." ".$location[array_rand($location)]." of ".$abstractnoun[array_rand($abstractnoun)];
        }

        //--------------------------------------------------------------------------------------------------------
        function makeRoom($id, $exits) {
            return array(
                "id" => $id,
                "exits" => $exits,
                "name" => names()
            );
        }

        function circular($length) {
            $roomArray = array();
            for($i = 0; $i < $length; $i++) {
                $room = makeRoom($i, array(modulo($i+1, $length),modulo($i-1, $length)));
                
                $roomArray[] = $room;
            }
            return $roomArray;
        }

        function string($length) {
            $roomArray = array();
            for($i = 0; $i < $length; $i++) {
                $exits = array();
                if($i > 0) {
                    $exits[] = $i - 1;
                }
                if($i < $length - 1) {
                    $exits[] = $i + 1;
                }
                // $room = array(
                //     "id" => $i,
                //     "exits" => $exits,
                //     "name" => "jjdj"
                // );
                $room = makeRoom($i, $exits);
                $roomArray[] = $room;
            }
        }

        function square($sideLength) {
            $roomArray = array();
            for($x = 0; $x < $sideLength; $x++) {
                for($y = 0; $y < $sideLength; $y++) {
                    $exits = array();
                    if($x > 0) {
                        $exits[] = to1D($x-1, $y, $sideLength);
                    }
                    if($y > 0) {
                        $exits[] = to1D($x, $y-1, $sideLength);
                    }
                    if($x < $sideLength - 1) {
                        $exits[] = to1D($x+1, $y, $sideLength);
                    }
                    if($y < $sideLength - 1) {
                        $exits[] = to1D($x, $y+1, $sideLength);
                    }
                    $room = makeRoom(to1D($x, $y, $sideLength), $exits);
                    $roomArray[] = $room;
                }
            }
            return $roomArray;
        }

        function branched($initBranch, $branchFactor) {
            $roomArray = array();
            $currentBranch = $initBranch;
            $start = 0;
            while($currentBranch >= 5) {
                for($i = 0; $i < floor($currentBranch); $i++) {
                    $exits = array();
                    if($i > 0) {
                        $exits[] = $i + $start - 1;
                    }
                    if($i < floor($currentBranch) - 1) {
                        $exits[] = $i + $start + 1;
                    }
                    $room = makeRoom($i + $start, $exits);
                    $roomArray[] = $room;
                }
                $start += floor($currentBranch);
                $currentBranch = $currentBranch*$branchFactor;
                
            }
            return $roomArray;
        }


        switch($type) {
            case "Circular":
                $arr = circular($worldSize);
                break;
            case "Square":
                $arr = square($worldSize);
                break;
            case "Branch":
                $arr = branched($worldSize, 0.7);
                break;
        }


        // $arr = circular($worldSize);
        // foreach($roomArray as $roomItem) {
        for($i = 0; $i < count($arr); $i++) {
            $room = new Room;
            $room->exit_id = $arr[$i]["id"];
            $room->name = $arr[$i]["name"];
            $room->world_id = $world->id;
            $room->exits = json_encode($arr[$i]["exits"]);
            $room->save();
        }
        // }

        return redirect('load');
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
        $rooms = DB::select("SELECT `name`, `exit_id`, `exits` FROM rooms WHERE world_id=$id");
        $params = DB::select("SELECT param1, param2 FROM worlds WHERE id=$id");
        return view('pages.canvas2')->with('rooms', $rooms)->with('type', $type)->with('params', $params);
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
        World::find($id)->delete();
    }

    public function showAllWorlds() {
        $worlds = DB::select(DB::raw('SELECT * FROM `worlds`'));

        // $rooms = DB::select(DB::raw('SELECT * FROM `rooms`'))
        // $data = DB::select(DB::raw('SELECT *,COUNT(*) FROM rooms LEFT JOIN worlds ON rooms.world_id = worlds.id GROUP BY worlds.id'));
        // $data = DB::select(DB::raw('SELECT worlds.id,worlds.name,worlds.type,
        // COUNT(rooms.id)
        // FROM worlds,rooms
        // WHERE worlds.id=rooms.world_id
        // GROUP BY worlds.id,worlds.name'));
        $data = array();
        foreach($worlds as $world) {
            $data[] = count(DB::select(DB::raw("SELECT rooms.id FROM `rooms` WHERE rooms.world_id=$world->id")));
        }
        return view('pages.load')->with('data', $worlds)->with('roomAmount',$data);
    }

    
}

