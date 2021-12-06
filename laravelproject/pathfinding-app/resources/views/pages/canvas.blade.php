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
    {{-- <script src="{{ URL::asset('/js/canvas.js') }}"></script> --}}
    <script>
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");

        // var world = 

        let arrayRandom = new Array(100).fill('').map(element => [Math.random(), Math.random()]);


        var rooms = {!! json_encode($rooms) !!};
        var type = {!! json_encode($type) !!};

        // let circleArray

        let x = 0;
        let y = 0;

        let isLeftClicking = false;

        let hasLeftClicked = false;

        let isRightClicking = false;

        let hasRightClicked = false;

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

        function Circle(x, y, radius, exits = []) {
            return {
                x: x,
                y: y,
                radius: radius,
                switch: false,
                exits: exits,
            }
        }

        let circleArray = new Array(50).fill('').map((element, index) =>
            Circle(canvas.width * arrayRandom[index][0], canvas.height * arrayRandom[index][1], 20)
            // new Array(5).fill('').map((e,i) => i)
            // [Math.floor(10*arrayRandom[index][1]),Math.floor(10*arrayRandom[index][0])]
        );

        /*
        for every circle in array:
        check if mouse is hovering over it(using the isInside function)
        check if mouse is clicking(using the isLeftClicking variable)
        if both of these conditions are true, i.e. both the function value(with inputs being the circle position and radius)
        then toggle the circle using the Circle.switch() function. 
        if switch is true, then set fillstyle to green
        if switch is false, then set fillstyle to grey(maybe)
        close the path

        at the end of this loop, do ctx.fill
        */

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

        function arrowDraw(x1, y1, x2, y2) {
            lineDraw()
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
            }
        }

        // let arrtest = [0, 0];

        // function addLines() {
        //     for (let i = 0; i < circleArray.length; i++) {
        //         if (circleArray[i].switch) {
        //             arrtest = [arrtest[1], i];
        //             addExits(circleArray, arrtest[0], arrtest[1]);
        //             circleArray[i].switch = false;
        //         }
        //     }
        // }

        function addLines() {
            // for (let i = 0; i < circleArray.length; i++) {
            //     if (circleArray[i].switch) {
                    
            //     }
            // }
            let temp = circleArray.reduce((c, v, i) => v.switch === true ? c.concat(i) : c, []);
            if(temp.length >= 2) {
                addExits(circleArray, temp[0], temp[1]);
                circleArray[temp[0]].switch = false;
                circleArray[temp[1]].switch = false;
            }
        }

        /*
        two steps:
        convert database info to an instance of a World class
        manipulate that data
        convert data back to database format
        insert into database and save
        */

        /*
        if inside circle, and the user is clicking, and the 
        */

        function mod(a, b) {
            return a - b * Math.floor(a / b);
        }



        function drawCircles() {
            for (let i = 0; i < circleArray.length; i++) {
                if (circleArray[i].switch) {
                    ctx.fillStyle = `rgb(255,0,0)`;
                } else {
                    ctx.fillStyle = `rgb(0,0,255)`;
                }
                if (isInsideCircle(x, y, circleArray[i].x, circleArray[i].y, circleArray[i].radius)) {
                    if(hasLeftClicked) {
                        circleArray[i].switch = !circleArray[i].switch;
                    }
                    if(isLeftClicking) {
                        circleArray[i].x = x;
                        circleArray[i].y = y;
                    }
                    circleDraw(circleArray[i].x, circleArray[i].y, circleArray[i].radius+3);
                } else {
                    circleDraw(circleArray[i].x, circleArray[i].y, circleArray[i].radius);
                }
            }
            // if(isInsideCircle(x, y, circleArray[i].x, circleArray[i].y, circleArray[i].radius) && hasLeftClicked) {
            //     circleArray.push(x, y, 20);
            // }
            hasLeftClicked = false;
        }



        function render(timestamp) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // for (let i = 0; i < circleArray.length; i++) {
            //     circleArray[i].x += 40 * Math.random() - 20;
            //     circleArray[i].y += 40 * Math.random() - 20;
            // }

            // lineDraw(x, y, circleArray[arrtest[1]].x, circleArray[arrtest[1]].y)
            addLines();
            drawLines();
            drawCircles();


            ctx.fill();

            requestAnimationFrame(render);
        }
        requestAnimationFrame(render);

        var inputs = document.getElementById("create_world").elements;
        console.log(inputs);


        //convert to database friendly format
        //---------------------------------------------------------------------------
    </script>
</body>

</html>