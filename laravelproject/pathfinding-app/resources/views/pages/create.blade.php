@extends('layouts.app')

@section('content')
    <div class="worldContainer">
        <div class="worldItem">
            <div class="worldCard shadow">
                <h2>World Type</h2>
                {{ Form::open(array('action' => 'App\Http\Controllers\WorldsController@store', 'method' => 'POST', 'class' => ''))}}
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
        {{Form::submit('Create', ['type' => 'submit', 'style' => '', 'class' => 'createWorldButton shadow btn'])}}

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
            console.log(worldType)

            switch (worldType) {

                case "circular":
                    let circularDiv = document.createElement('DIV');
                    circularDiv.innerHTML = `<div class="worldCard shadow">
                                        <h2>Circular</h2>
                                        
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Size")}}
                                            {{Form::number('worldSize', '', ['class' => 'textInput'])}}    
                                        </div>
                                        <br>
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Name")}}
                                            {{Form::number('worldName', '', ['class' => 'textInput'])}}    
                                        </div>
                                        <br>
                                        
                                        
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
                                        <br>
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Name")}}
                                            {{Form::number('worldName', '', ['class' => 'textInput'])}}    
                                        </div>
                                        <br>
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
                                            {{Form::number('worldName', '', ['class' => 'textInput'])}}    
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
    </script>   

<style>
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