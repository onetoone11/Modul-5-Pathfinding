@extends('layouts.app')

@section('content')
    <div class="d-flex w-100 vh-100 justify-content-center" style="background-color: #202225">
        <div class="d-flex flex-column justify-content-evenly">
            <h1 class="text-center mt-5 mb-50" style="color: white;">Titel</h1>
            <div class="text-center fs-2 d-flex">
                <div class="d-flex justify-content-evenly vw-100">
                    <a href="/create" class="shadow" style="background-color: hsl(235,85.6%,64.7%); width: 150px; color: white; border-radius: 8px; border: 0; text-decoration: none; cursor: pointer">Create</a>
                    <a href="/load" class="shadow" style="background-color: hsl(235,85.6%,64.7%); width: 150px; color:white; border-radius: 8px; border: 0; text-decoration: none; cursor: pointer">Load</a>
                </div>
            </div>
        </div>
    </div>
@endsection