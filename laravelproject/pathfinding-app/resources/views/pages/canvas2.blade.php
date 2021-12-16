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

<body style="background-color: #202225">
        {{-- <form id="create_world" class="form-group">
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
        </form> --}}

        {{-- {!! Form::open(['action' => 'App\Http\Controllers\WorldsController@update', 'method' => 'PUT']) !!}
        {!! Form::radio('type', 'string', true) !!}
        {!! Form::close() !!} --}}
        <div class="vw-100 vh-100 d-flex flex-column justify-content-center align-items-center">
        <canvas id="canvas" width="1000" height="800" class="border border-dark"></canvas>
        <div class="d-flex justify-content-between">
            <div>

        <div class="form-check">
        <input type=radio name="canvasMode" id="viewCanvas" value="view" class="form-check-input" checked>
        <label for="viewCanvas" class="form-check-label text-light">View</label>
        </div>
        <div class="form-check">
        <input type=radio name="canvasMode" id="pathfindCanvas" value="pathfind" class="form-check-input">
        <label for="pathfindCanvas" class="form-check-label text-light">Pathfind</label>
        </div>
        <div class="form-check">
        <input type="radio" name="canvasMode" id="editCanvas" value="edit" class="form-check-input">
        <label for="editCanvas" class="form-check-label text-light">Edit</label>
        </div>
        {{-- <div class="form-check">
        <input type="radio" name="canvasMode" id="addCanvas" value="add_room" class="form-check-input">
        <label for="editCanvas" class="form-check-label text-light">Add Room</label>
        </div> --}}
        </div>
        <input type="button" id="saveCanvas" value="Save" class="btn btn-primary btn-lg px-5">
        {{-- {{ Form::open(array('action' => 'App\Http\Controllers\WorldsController@update', 'method' => 'POST', 'class' => ''))}} --}}
        </div>
    </div>





    </div>
    {{-- <script src="rooms.js"></script> --}}
    {{-- <script src="{{ URL::asset('/js/canvas.js') }}"></script> --}}
    <script>
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");

        //const saveBtn = document.getElementById()

        // parse data from database
        //---------------------------------------------------------------------------------------------------------------------
        var rooms = {!! json_encode($rooms) !!};
        
        var type = {!! json_encode($type) !!};

        var params = {!! json_encode($params) !!};

        var param1 = Number(params[0].param1);
        var param2 = Number(params[0].param2);
        type = type[0].type;

        let roomtemp = {};
        rooms.map(element => roomtemp[element.exit_id] = JSON.parse(element.exits));
        rooms = roomtemp;
        let roomAmount = Object.keys(rooms).length;

        console.log(rooms);
        console.log(type);
        //---------------------------------------------------------------------------------------------------------------------


        function circleDraw(x, y, radius) {
            ctx.beginPath();
            ctx.lineWidth = 5;
            ctx.arc(x, y, radius, 0, 2 * Math.PI);
            ctx.fill();

            ctx.strokeStyle = "black";
            ctx.stroke();
        }

        function lineDraw(x1, y1, x2, y2) {
            ctx.lineWidth = 5;
            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.stroke();
        }
        
        let arrayRandom = new Array(roomAmount).fill('').map(element => [Math.random(), Math.random()]);
        // let circleArray

        let x = 0;
        let y = 0;

        let state = document.querySelector('input[name="canvasMode"]:checked').value;

        let isLeftClicking = false;

        let hasLeftClicked = false;

        let isRightClicking = false;

        let hasRightClicked = false;

        let selected = [];

        canvas.addEventListener('mousemove', e => {
            x = e.offsetX;
            y = e.offsetY;
        });

        canvas.addEventListener('mousedown', e => {
            isLeftClicking = true;
            hasLeftClicked = true;
        });

        canvas.addEventListener('mouseup', e => {
            isLeftClicking = false;
        });

        canvas.addEventListener('contextmenu', function(ev) {
            ev.preventDefault();
            alert('success!');
            return false;
        }, false);

        function isInsideCircle(x1, y1, x2, y2, r) {
            if (((x1 - x2) ** 2 + (y1 - y2) ** 2 - r ** 2) < 0) {
                return true;
            }
        }

        function Circle(x, y, radius, exits, id, z_index = 0) {
            return {
                x: x,
                y: y,
                radius: radius,
                z_index: z_index,
                exits: exits,
                id: id,
            }
        }

        switch(type) {
            
            case "Circular":
                let size = Math.min(canvas.height, canvas.width);
                circleArray = new Array(roomAmount).fill('').map((element, index) =>
                    Circle(0.4*size*Math.cos(index*2*Math.PI/roomAmount) + canvas.width/2, 0.4*size*Math.sin(index*2*Math.PI/roomAmount) + canvas.height/2, 20, rooms[index], index)
                );
                break;
            case "Square":
                circleArray = [];
                for(let x = 0; x < param1; x++) {
                    for(let y = 0; y < param2; y++) {
                        circleArray.push(
                            Circle(x)
                        )
                    }
                }
                break;
            case "Branch":
                break;
        }

        function drawLines() {
            for (let i = 0; i < circleArray.length; i++) {
                for (let j = 0; j < circleArray[i].exits.length; j++) {
                    lineDraw(circleArray[i].x, circleArray[i].y, circleArray[circleArray[i].exits[j]].x, circleArray[circleArray[i].exits[j]].y);
                }
            }
        }

        function addExits(circles, from, to) {
            if (!circles[from].exits.includes(to)) {
                circles[from].exits.push(to);
            } else {
                console.log("WRONG")
            }
        }

        /*
        [1,2,3,4,5]
        on click outside, clear selected

        */

        function addLines() {
            if(state === "edit") {
                selected.map(element => {
                    lineDraw(circleArray[element].x, circleArray[element].y, circleArray[circleArray[i].exits[j]].x, circleArray[circleArray[i].exits[j]].y);
                })
            }
        }

        function color(i) {
            if(selected.includes(i)) {
                return "green";
            } else {
                return "red";
            }
        }

        let dragging = null;

        function select(i) {
            switch(state) {
                case "edit":
                    if(isInsideCircle(x, y, circleArray[i].x, circleArray[i].y, circleArray[i].radius)) {
                        if(hasLeftClicked) {
                            if(selected.includes(i)) {
                                selected = selected.filter(e => e !== i);
                            } else {
                                if(selected.length === 2) {
                                    selected.push(i);
                                    selected.shift();
                                }
                                if(selected.length > 2) {
                                    while(selected.length > 2) {
                                        selected.shift();
                                    }
                                }
                                if(selected.length < 2) {
                                    selected.push(i);
                                }   
                            }
                        }
                    }
                    if(selected.length === 2) {
                        addExits(circleArray, selected[0], selected[1]);
                        selected = [];
                    }
                    break;
                case "view":
                    
                    break;
                case "pathfind":
                    if(isInsideCircle(x, y, circleArray[i].x, circleArray[i].y, circleArray[i].radius)) {
                        if(hasLeftClicked) {
                            if(selected.includes(i)) {
                                selected = selected.filter(e => e !== i);
                            } else {
                                selected.push(i);
                            }
                        }
                    }
                    break;
            }
        }

        function drawCircles() {
            circleArray.map((element, index) => {
                select(index);
                ctx.fillStyle = color(index);
                if(dragging === index) {
                    circleArray[index].x = x;
                    circleArray[index].y = y;
                }
                circleDraw(circleArray[index].x, circleArray[index].y, circleArray[index].radius);
                ctx.font = "10px Arial";
                ctx.fillStyle = "black";
                ctx.fillText(index, circleArray[index].x, circleArray[index].y);
            });
            if(!circleArray.some(el => isInsideCircle(x, y, el.x, el.y, el.radius))) {
                if(hasLeftClicked) {
                    selected = [];
                }
            }
        }

        function mod(a, b) {
            return a - b * Math.floor(a / b);
        }



        function render(timestamp) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            
            drawLines();
            drawCircles();


            ctx.fill();

            state = document.querySelector('input[name="canvasMode"]:checked').value;
            hasLeftClicked = false;
            hasRightClicked = false;
            requestAnimationFrame(render);
        }
        requestAnimationFrame(render);


        //convert to database friendly format
        //---------------------------------------------------------------------------
    </script>
</body>

</html>