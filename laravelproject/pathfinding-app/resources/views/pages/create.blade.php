@extends('layouts.app')

@section('content')
    <div class="worldContainer">
        {{ Form::open(array('action' => 'App\Http\Controllers\WorldsController@store', 'method' => 'POST', 'class' => ''))}}
        <div class="worldItem">
            <div class="worldCard shadow">
                <h2>World Type</h2>
                <div class="d-flex align-items-center justify-content-between vw-10">
                    {{Form::label("Circular")}}
                    {{Form::radio('worldType', 'Circular', false, ['id' => 'circularWorld', 'class' => 'worldType'])}}    
                </div>
                <br>
                <div class="d-flex align-items-center justify-content-between">
                    {{Form::label("Square")}}
                    {{Form::radio('worldType', 'Square', false, ['id' => 'squareWorld', 'class' => 'worldType'])}}
                </div>
                <br>
                <div class="d-flex align-items-center justify-content-between">
                    {{Form::label("Branch")}}
                    {{Form::radio('worldType', 'Branch', false, ['id' => 'branchWorld', 'class' => 'worldType'])}}
                </div> 
            </div>    
        </div>
        
        <div class="worldItem" id="worldSettings">
            
        </div>
        
        {{-- Check if world type selected (@if) --}}
        {{Form::submit('Create', ['type' => 'submit', 'style' => '', 'class' => 'createWorldButton shadow btn', 'onclick'=> 'submit1()'])}}

        {{Form::close()}}
    </div>
    
    
    
    <script>

        document.getElementById('circularWorld').addEventListener('click', () => {
            selectedWorldType("circular")
        })
        
        document.getElementById('squareWorld').addEventListener('click', () => {
            selectedWorldType("square")
        })
        
        document.getElementById('branchWorld').addEventListener('click', () => {
            selectedWorldType("branch")
        })

        function selectedWorldType(worldType) {

            switch (worldType) {

                case "circular":
                    let circularDiv = document.createElement('DIV');
                    circularDiv.innerHTML = `<div class="worldCard shadow">
                                                <h2>Circular</h2>
                                                
                                                <div class="d-flex flex-column" >
                                                    {{Form::label("World Size")}}
                                                    {{Form::number('worldSize', '', ['class' => 'textInput'])}}    
                                                </div>
                                                <div class="d-flex flex-column" >
                                                    {{Form::label("World Name")}}
                                                    {{Form::text('worldName')}}    
                                                </div>
                                            </div>` 
                    if(document.getElementById("worldSettings").children.length){
                        document.getElementById("worldSettings").removeChild(document.getElementById("worldSettings").children[0])
                    }
                    document.getElementById("worldSettings").appendChild(circularDiv)
                    break;
                
                case "square":
                    let squareDiv = document.createElement('DIV');
                    squareDiv.innerHTML = `<div class="worldCard shadow">
                                                <h2>Square</h2>
                                                <div class="d-flex flex-column" >
                                                    {{Form::label("World Size")}}
                                                    {{Form::number('worldSize', '', ['class' => 'textInput'])}}    
                                                </div>
                                                <div class="d-flex flex-column" >
                                                    {{Form::label("World Name")}}
                                                    {{Form::text('worldName')}}      
                                                </div>
                                            </div>`
                    if(document.getElementById("worldSettings").children.length){
                        document.getElementById("worldSettings").removeChild(document.getElementById("worldSettings").children[0])
                    }
                    document.getElementById("worldSettings").appendChild(squareDiv)
                    break;

                case "branch":
                    let branchDiv = document.createElement('DIV');
                    branchDiv.innerHTML = `<div class="worldCard shadow">
                                                <h2>Branch</h2>
                                                <div class="d-flex flex-column" >
                                                    {{Form::label("World Size")}}
                                                    {{Form::number('worldSize', '', ['class' => 'textInput'])}}    
                                                </div>
                                                <div class="d-flex flex-column" >
                                                    {{Form::label("World Name")}}
                                                    {{Form::text('worldName')}}    
                                                </div>
                                                <div class="d-flex flex-column" >
                                                    {{Form::label("Branch Factor")}}
                                                    {{Form::number('Branch Factor', '', ['class' => 'textInput'])}}    
                                                </div>
                                            </div>`
                    if(document.getElementById("worldSettings").children.length){
                        document.getElementById("worldSettings").removeChild(document.getElementById("worldSettings").children[0])
                    }
                    document.getElementById("worldSettings").appendChild(branchDiv) 
                    break;

                default:

                    break;
            }

        }

        var adjective = [
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
        ];

        var locationn = [
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
        ];

        var abstractnoun = [
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
        ];

        const names = () => {
            return "A " + adjective[Math.floor(Math.random() * adjective.length)] + " " + locationn[Math.floor(Math.random() * locationn.length)] + " of " + abstractnoun[Math.floor(Math.random() * abstractnoun.length)];
        }

        class Room {
            constructor(id) {
                this.id = id;
                this.name = names();
                this.exits = [];
            }

            name() {
                return this.name;
            }

            exits() {
                return this.exits;
            }

            addExits(...exits) {
                this.exits.push(...exits);
            }

            id() {
                return this.id;
            }
        }

        const mod = (a, b) => {
            return a - b * Math.floor(a / b);
        }

        const neighbours = [
            [1, 0],
            [0, 1],
            [-1, 0],
            [0, -1]
        ]

        class World {
            constructor(name, type, param) {
                this.name = name;
                this.rooms = [];
                this.length = param;
                this.type = type;
                switch(type) {
                    case "string":
                        this.createStringRooms(param);
                        break;
                    case "circular":
                        this.createCircularRooms(param);
                        break;
                    case "grid":
                        this.createSquareRoom(param);
                        break;
                    case "branched":
                        this.createBranchedRoom(param);
                        break;
                    default:
                        console.log("Invalid input, must specify type");
                        break;
                }
            }

            length() {
                return this;
            }

            createStringRooms(length) {
                this.rooms = [];
                const createStringWorld = (length, count) => {
                    if(count === length)
                        return [[count-1]];
                    if(count === 0)
                        return [[1], ...createStringWorld(length, count+1)];
                    return [[count-1,count+1], ...createStringWorld(length, count+1)];
                }
                let temp = createStringWorld(length, 0);
                for(let i = 0; i < length; i++) {
                    let temproom = new Room(i);
                    temproom.addExits(...temp[i]);
                    this.rooms[i] = temproom;
                }
            }

            createCircularRooms() {
                for (let i = 0; i < this.length; i++) {
                    let temp = new Room(i);
                    temp.addExits(mod(i + 1, this.length), mod(i - 1, this.length));
                    this.rooms[i] = temp;
                }
            }

            createSquareRoom(sideLength) {
                for (let x = 0; x < sideLength; x++) {
                    for (let y = 0; y < sideLength; y++) {
                        let temp = new Room(this.to1D(x, y, sideLength))
                        temp.addExits(...neighbours.map(element => (x + element[0] < 0 || x + element[0] >= sideLength || y + element[1] < 0 || y + element[1] >= sideLength) ? null : this.to1D(x + element[0], y + element[1], sideLength)).filter(element => element !== null));
                        this.rooms[temp.id] = temp;
                    }
                }
            }

            createBranchedRoom(lengthOfMainBranch, branchFactor = 0.7) {
                const count = a => (a < 5) ? [] : [a, ...count(a * branchFactor)].map(element => Math.floor(element));
                const branches = count(lengthOfMainBranch);
                const totalLength = branches.reduce((acc, cur) => acc + cur);

                this.rooms = new Array(totalLength).fill('').map((element, index) => new Room(index));

                let randAwway = [];
                for (let i = 0; i < branches.length - 1; i++) {
                    randAwway[i] = Math.floor(Math.abs(Math.abs(branches[i + 1] - branches[i]) * Math.random()));
                }

                let currentBranch = 0;

                for (let i = 0; i < branches.length; i++) {
                    for (let j = 0; j < branches[i]; j++) {
                        let currentPosition = j + currentBranch;
                        if (j === 0)    //if in start position
                            this.rooms[currentPosition].addExits(currentPosition + 1);
                        if (j > 0 && j < branches[i] - 1)
                            this.rooms[currentPosition].addExits(currentPosition + 1, currentPosition - 1);
                        if (j === branches[i] - 1)  //if on end of branch
                            this.rooms[currentPosition].addExits(currentPosition - 1);
                        if (j === randAwway[i]) { //if 
                            this.rooms[currentPosition].addExits(currentBranch + branches[i]);
                            this.rooms[currentBranch + branches[i]].addExits(currentPosition);
                            this.rooms[currentPosition + branches[i + 1]].addExits(currentBranch + branches[i] + branches[i + 1] - 1);
                            this.rooms[currentBranch + branches[i] + branches[i + 1] - 1].addExits(currentPosition);
                        }
                        
                    }
                    currentBranch += branches[i];
                }
                console.log(randAwway, branches);
            }

            to1D(x, y, rowlength) {
                return (y * rowlength) + x;
            }

            getRoom(id) {
                return this.rooms[id];
            }
        }

        function submit1() {
            localStorage.setItem('worldSize',document.getElementById('worldSizeInput').value);
        }

        
    </script>   

<style>
    form {
        display: flex;
        justify-content: center;
    }

    .worldType {
        transform: scale(1.5)
    }

    .createWorldButton {

        background-color: hsl(235,85.6%,64.7%);
        padding: 16px;
        padding-inline: 32px;
        color: white;
        border-radius: 8px;
        bottom: 10%;
        position: absolute;
    }

    .createWorldButton:hover {
        color: lightskyblue
    }

    .worldContainer {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        background-color: #202225;
    }

    .worldItem {
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        font-size: 25px;
        color: #b9bbbe; 
        margin-inline: 16px;
    }

    .worldItem h2 {
        color: #fff; 

    }

    .worldCard {
        background-color: #36393f;
        padding: 25px;
        border-radius: 8px;
        height: 350px;
        width: 50vh;

    }
</style>
@endsection