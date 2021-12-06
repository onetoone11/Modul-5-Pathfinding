@extends('layouts.app')

@section('content')
    <div class="worldContainer">
        <div class="worldItem">
            <div class="worldCard shadow">
                <h2>World Type</h2>
                {{ Form::open(array('action' => 'App\Http\Controllers\WorldsController@store', 'method' => 'POST', 'class' => ''))}}
                <div class="d-flex align-items-center justify-content-between vw-10">
<<<<<<< HEAD
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
=======
                    {{Form::label("circularWorld" ,"Circular", ['class' => 'btn btn-secondary w-100'])}}
                    {{Form::radio('worldType', '', false, ['id' => 'circularWorld', 'class' => 'btn-check'])}}    
                </div>
                <br>
                <div class="d-flex align-items-center justify-content-between">
                    {{Form::label("squareWorld","Square", ['class' => 'btn btn-secondary w-100'])}}
                    {{Form::radio('worldType', '', false, ['id' => 'squareWorld', 'class' => 'btn-check'])}}
                </div>
                <br>
                <div class="d-flex align-items-center justify-content-between">
                    {{Form::label("branchWorld","Branch", ['class' => 'btn btn-secondary w-100'])}}
                    {{Form::radio('worldType', '', false, ['id' => 'branchWorld', 'class' => 'btn-check'])}}
>>>>>>> 7dfedb8e9916c92715d9318458ae8c196a2eb923
                </div>
                
                <div class="worldItem" id="worldSettings">
            
                </div>

                {{Form::submit('Create', ['type' => 'submit', 'style' => '', 'class' => 'createWorldButton shadow'])}}
                {{-- <div style="position: absolute; left:50%; bottom: 10%">
                    <a href="#" class="createWorldButton shadow">Create</a>
                </div> --}}
                
                {{Form::close()}}
            </div>
        </div>
        
        
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
            console.log(worldType)

            switch (worldType) {

                case "circular":
                    let circularDiv = document.createElement('DIV');
                    circularDiv.innerHTML = `<div class="worldCard shadow">
                                        <h2>Circular</h2>
                                        {{Form::open()}}
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Size")}}
                                            {{Form::text('World Size', '', ['class' => 'textInput'])}}    
                                        </div>
                                        <br>
<<<<<<< HEAD
                                        
=======
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Name")}}
                                            {{Form::text('World Name', '', ['class' => 'textInput form-control'])}}
                                        </div>
                                        <br>
>>>>>>> 7dfedb8e9916c92715d9318458ae8c196a2eb923
                                        
                                        {{Form::close()}}
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
                                        {{Form::open()}}
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Size")}}
                                            {{Form::text('World Size', '', ['class' => 'textInput'])}}    
                                        </div>
                                        <br>
                                        {{Form::close()}}
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
                                        {{Form::open()}}
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Size")}}
                                            {{Form::text('World Size', '', ['class' => 'textInput'])}}    
                                        </div>
                                        <br>
                                        <div class="d-flex flex-column" >
                                            {{Form::label("Branch Factor")}}
                                            {{Form::text('Branch Factor', '', ['class' => 'textInput'])}}    
                                        </div>
                                        <br>
                                        {{Form::close()}}
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
    </script>   

<style>
    .worldType {
        transform: scale(1.5)
    }

    .createWorldButton {
        position: relative; 
        bottom: -10%;
        background-color: hsl(235,85.6%,64.7%);
        padding: 16px;
        padding-inline: 32px;
        color: white;
        text-decoration: none;
        left: -50%;
        border-radius: 8px;
        position: absolute; 
        left:50%; 
        bottom: 10%;
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
        font-size: 30px;
        color: #b9bbbe; 
        width: 25%;
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
    }
</style>
@endsection