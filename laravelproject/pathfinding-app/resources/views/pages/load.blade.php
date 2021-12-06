<?php
header('Location: http://localhost:8000')

?>

@extends('layouts.app')

@section('content')
    <div class="d-flex w-100 vh-100 justify-content-center" style="background-color: #202225; position: relative; overflow:auto; padding: 32px 0px">
        <div class="shadow" style="background-color: #36393f; width:70%; min-height: 70%; margin: auto; border-radius: 16px;  top: 5%;">
            <div style="display:flex; justify-content:space-evenly; width: 100%; padding: 8px; color:#FFF; border-bottom:1px solid hsla(0 0% 100% / 0.06);">
                <div style="width: 20%; text-align:center;">
                    <h3>World ID</h3>
                </div>
                <div style="width: 20%; text-align:center;">
                    <h3>World Name</h3>
                </div>
                <div style="width: 20%; text-align:center;">
                    <h3>World Type</h3>
                </div>
                <div style="width: 20%; text-align:center;">
                    <h3>World Size</h3>    
                </div>
                <div style="width: 20%"></div>    
            </div>
            <div class="worldContainer" id="worldContainer">
                
            </div>
        </div>
    </div>


    <script>

        let parentDiv = document.getElementById('worldContainer');

        let worlds = {!! json_encode($data)!!};

        console.log(worlds);

        for(let i = 0; i < worlds.length; i++) {
            console.log(worlds[i]);
            addWorldItem(worlds[i].id, worlds[i].name, worlds[i].type);
        }



        function addWorldItem(worldId, worldName, worldType) {

            let randNum = Math.floor(Math.random()*100)

            let child = document.createElement('DIV');
            child.innerHTML = `<div style="display: flex; justify-content:space-evenly; color:#b9bbbe; padding:8px; border-bottom: 1px solid hsla(0 0% 100% / 0.06)">
                                    <div style="width: 20%; text-align:center;">
                                        <h3>${worldId}</h3>
                                    </div>
                                    <div style="width: 20%; text-align:center;">
                                        <h3>${worldName}</h3>
                                    </div>
                                    <div style="width: 20%; text-align:center;">
                                        <h3>${worldType}</h3>
                                    </div>
                                    <div style="width: 20%; text-align:center;">
                                        <h3>${randNum}</h3>    
                                    </div>
                                    <div style="width: 20%; text-align:center; display:flex">
                                        <a href="#" style="color: #b9bbbe; background-color: #2f3136;" class="fs-5 btn">Edit</a>
                                        <a href="#" style="color: red; margin-left: 8px; background-color: #2f3136;" class="fs-5 btn">Delete</a>
                                    </div>   
                                </div>`
            parentDiv.appendChild(child)
        }
    </script>
@endsection