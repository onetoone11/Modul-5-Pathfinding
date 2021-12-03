<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ URL::asset('/css/canvas.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

</head>

<body>
    <div id="app">
        <form id="create_world" class="form-group">
            <p>Type</p>
            <div>
                <input class="radio_select radio" type="radio" id="string_select" name="world_type">
                <label for="string_select">String</label>
            </div>

            <div>
                <input class="radio_select" type="radio" id="circular_select" name="world_type">
                <label for="circular_select">Circular</label>
            </div>

            <div>
                <input class="radio_select" type="radio" id="branched_select" name="world_type">
                <label for="branched_select">Branched</label>
            </div>

            <div>
                <input class="radio_select" type="radio" id="grid_select" name="world_type">
                <label for="grid_select">Grid</label>
            </div>

            <input type="text" id="title_input" placeholder="Title...">

            <input type="number" id="param_input" placeholder="Parameter">

            <input type="number" id="complexity_input" placeholder="Complexity">

            <input type="button" id="create_button" value="Create">
        </form>

        {{-- {!! Form::open(['action' => 'App\Http\Controllers\WorldsController@update', 'method' => 'PUT']) !!}
        {!! Form::radio('type', 'string', true) !!}
        {!! Form::close() !!} --}}
        <canvas id="canvas" width="1000" height="800" class="border border-dark"></canvas>


    </div>
    {{-- <script src="rooms.js"></script> --}}
    <script src="{{ URL::asset('/js/canvas.js') }}"></script>
</body>

</html>