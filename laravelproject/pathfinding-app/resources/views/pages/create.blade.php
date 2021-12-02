@extends('layouts.app')

@section('content')
    <div class="w-100 vh-100 d-flex justify-content-center" style="background-color: #36393f">
        <div class="d-flex flex-column">
            {{Form::open()}}
            {{Form::label("Helo")}}
            {{Form::radio('name', 'value', 'text')}}
            {{Form::label("Helo")}}
            {{Form::radio('name', 'value', 'text')}}
            {{Form::label("Helo")}}
            {{Form::radio('name', 'value', 'text')}}
            {{Form::close()}}
        </div>
        
    </div>
@endsection