@extends('layouts.app')

@section('content')
    <div class="worldContainer">
        <div class="worldItem">
            <div class="worldCard">
                <h2>World Type</h2>
                {{Form::open()}}
                <div class="d-flex align-items-center justify-content-between vw-10">
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
                </div>
                {{Form::close()}}
            </div>
        </div>
        <div class="worldItem" id="worldSettings">
            
        </div>
        
    </div>
    <div style="position: relative; left: 50%">
        <a href="#" class="createWorldButton">Create</a>
    </div>
    
    <style>
        .createWorldButton {
            position: absolute; 
            bottom: 10%;
            background-color: hsl(235,85.6%,64.7%);
            padding: 12px;
            color: white;
            text-decoration: none;
            left: -50%
        }

        .worldContainer {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            background-color: #36393f;
        }

        .worldItem {
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            font-size: 30px;
            color: white; 
            width: 25%;
            margin-inline: 16px;
        }

        .worldCard {
            background-color: gray;
            padding: 25px;
            border-radius: 8px;
            height: 350px;
        }
    </style>
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
                    circularDiv.innerHTML = `<div class="worldCard">
                                        <h2>Circular</h2>
                                        {{Form::open()}}
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Size")}}
                                            {{Form::text('World Size', '', ['class' => 'textInput'])}}    
                                        </div>
                                        <br>
                                        <div class="d-flex flex-column" >
                                            {{Form::label("World Name")}}
                                            {{Form::text('World Name', '', ['class' => 'textInput form-control'])}}
                                        </div>
                                        <br>
                                        
                                        {{Form::close()}}
                                    </div>` 
                    if(document.getElementById("worldSettings").children.length){
                        document.getElementById("worldSettings").removeChild(document.getElementById("worldSettings").children[0])
                    }
                    document.getElementById("worldSettings").appendChild(circularDiv)
                    break;
                
                case "square":
                    let squareDiv = document.createElement('DIV');
                    squareDiv.innerHTML = `<div class="worldCard">
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
                    branchDiv.innerHTML = `<div class="worldCard">
                                        <h2>Branch</h2>
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
                    document.getElementById("worldSettings").appendChild(branchDiv) 
                    break;

                default:

                    break;
            }

        }
    </script>   
@endsection