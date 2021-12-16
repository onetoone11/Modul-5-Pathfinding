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
        <div class="vw-100 vh-100 d-flex justify-content-center align-items-center">
        <canvas id="canvas" width="1000" height="800" class="border border-dark position-absolute"></canvas>
        <div class="d-flex justify-content-between position-absolute">
            <div>

        <div class="form-check">
        <input type=radio name="canvasMode" id="viewCanvas" value="view" class="form-check-input" checked>
        <label for="viewCanvas" class="form-check-label">View</label>
        </div>
        <div class="form-check">
        <input type=radio name="canvasMode" id="pathfindCanvas" value="pathfind" class="form-check-input">
        <label for="pathfindCanvas" class="form-check-label">Pathfind</label>
        </div>
        <div class="form-check">
        <input type="radio" name="canvasMode" id="editCanvas" value="edit" class="form-check-input">
        <label for="editCanvas" class="form-check-label">Edit</label>
            </div>
        </div>
        <input type="button" id="saveCanvas" value="Save" class="btn btn-primary btn-lg px-5" disabled>
        </div>
    </div>





    </div>
    {{-- <script src="rooms.js"></script> --}}
    {{-- <script src="{{ URL::asset('/js/canvas.js') }}"></script> --}}
    <script>
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");

        // parse data from database
        //---------------------------------------------------------------------------------------------------------------------
        var rooms = {!! json_encode($rooms) !!};
        
        var type = {!! json_encode($type) !!};
        type = type[0].type;

        let roomtemp = {};
        rooms.map(element => roomtemp[element.exit_id] = JSON.parse(element.exits));
        rooms = roomtemp;
        let roomAmount = Object.keys(rooms).length;

        console.log(rooms);
        console.log(type);
        //---------------------------------------------------------------------------------------------------------------------

        
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

        // function Circle(x, y, radius, exits = [], z_index = 0) {
        //     return {
        //         x: x,
        //         y: y,
        //         radius: radius,
        //         switch: false,
        //         exits: exits,
        //         z_index: z_index,
        //     }
        // }

        function Circle(x, y, radius, exits, z_index = 0) {
            return {
                x: x,
                y: y,
                radius: radius,
                z_index: z_index,
                exits: exits,
            }
        }

        switch(type) {
            case "Circular":
                let circleArray = new Array(roomAmount).fill('').map((element, index) =>
                    Circle(50*Math.cos(roomAmount*2*Math.PI/index), 50*Math.sin(roomAmount*2*Math.PI/index), 20, rooms[index])
                );
                break;
            case "Grid":
                break;
            case "String":
                break;
        }

        // let circleArray = new Array(roomAmount).fill('').map((element, index) =>
        //             Circle(canvas.width*Math.cos(roomAmount*2*Math.PI/index), canvas.height*Math.sin(roomAmount*2*Math.PI/index), 20, rooms[index])
        // );
        let circleArray = [];

        if(type === 'Circular') {
            circleArray = new Array(roomAmount).fill('').map((element, index) =>
                    Circle(500*Math.cos(roomAmount*2*Math.PI/index), 500*Math.sin(roomAmount*2*Math.PI/index), 20, rooms[index])
            );
        }

        // Circle(canvas.width * arrayRandom[index][0], canvas.height * arrayRandom[index][1], 20, rooms[index])
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

        // function adjacencyMatrix(...nodes) {
            
        // }

        // let adjacencyMatrix = circleArray.map(element => new Array(circleArray.length));s

        function fromDatabaseToObject() {

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
        // let selected = [];

        function editSelected(id) {
            selected.push(id);
            selected.shift();
            return selected;
        }

        function addLines() {
            if(state === "edit") {
                selected.map(element => {
                    lineDraw(circleArray[element].x, circleArray[element].y, circleArray[circleArray[i].exits[j]].x, circleArray[circleArray[i].exits[j]].y);
                })
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

        // let selected = function


        function drawCircles() {
            // circleArray.map((e,i) => {
            //     switch(state) {
            //         case "view":
            //             if(isInsideCircle(x, y, circleArray[i].x, circleArray[i].y, circleArray[i].radius)) {
            //                 if(isLeftClicking || circleArray[i].switch) {
            //                     circleArray[i].switch = true;
            //                     circleArray[i].x = x;
            //                     circleArray[i].y = y;
            //                 }
            //             }
            //             break;
            //         case "edit":

            //             break;
            //         case "pathfind":

            //             break;
            //     }
            //     circleDraw(circleArray[i].x, circleArray[i].y, circleArray[i].radius);
            // })

            /*
            the different modes:
                when in edit mode, these features are available:
                    select any two nodes to establish a bidirectional(eventually unidirectional) connection between them
                    changing color is optional
                when in view mode, these features are available:
                    drag nodes around, without coloring them
                when in pathfinding mode, these features are available:
                    click any two nodes, one starting node and one destination node. Alerts should show up informing the user of whether they are choosing a source or a destination
                    these nodes should be colored.


                instead of storing switches for turning the nodes on and off, store a pair of numbers(array) that contain the id of the last selected 
            */




            // for (let i = 0; i < circleArray.length; i++) {
            //     if (circleArray[i].switch && state === "edit") {
            //         ctx.fillStyle = `rgb(255,0,0)`;
            //     } else {
            //         ctx.fillStyle = `rgb(0,0,255)`;
            //     }
            //     if (isInsideCircle(x, y, circleArray[i].x, circleArray[i].y, circleArray[i].radius)) {
            //         switch(state) {
            //             case "view":
            //                 if(isLeftClicking) {
            //                     circleArray[i].x = x;
            //                     circleArray[i].y = y;
            //                 }
            //                 break;
            //             case "pathfind":
            //                 if(isLeftClicking) {
            //                     circleArray[i].switch = true;
            //                 }
            //                 break;
            //             case "edit":
            //                 if(hasLeftClicked) {
            //                     circleArray[i].switch = !circleArray[i].switch;
            //                 }
            //                 break;
            //             }
            //         circleDraw(circleArray[i].x, circleArray[i].y, circleArray[i].radius+3);
            //     } else {
            //         circleDraw(circleArray[i].x, circleArray[i].y, circleArray[i].radius);
            //     }
            // }
            // hasLeftClicked = false;


            circleArray.map((e,i) => {
                ctx.fillStyle = `rgb(255,0,0)`;
                // if(selected.includes(i)) {
                //     ctx.fillStyle = `rgb(255,0,0)`;
                // } else {
                //     ctx.fillStyle = `rgb(0,0,255)`;
                // }
                // if(isInsideCircle(x, y, circleArray[i].x, circleArray[i].y, circleArray[i].radius)) {
                //     if(hasLeftClicked) {
                //         if(selected.includes(i)) {
                //             selected = selected.filter(element => element !== i);
                //         } else {
                //             selected.push(i);
                //         }
                //     }
                // }
                circleDraw(circleArray[i].x, circleArray[i].y, circleArray[i].radius);
            });
            hasLeftClicked = false;
        }



        function render(timestamp) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // for (let i = 0; i < circleArray.length; i++) {
            //     circleArray[i].x += 40 * Math.random() - 20;
            //     circleArray[i].y += 40 * Math.random() - 20;
            // }

            // lineDraw(x, y, circleArray[arrtest[1]].x, circleArray[arrtest[1]].y)
            // addLines();
            drawLines();
            drawCircles();


            ctx.fill();

            state = document.querySelector('input[name="canvasMode"]:checked').value;
            requestAnimationFrame(render);
        }
        requestAnimationFrame(render);


        //convert to database friendly format
        //---------------------------------------------------------------------------

        // Pathfinding
        //---------------------------------------------------------------------------

        // A-star
        /* function to2d(arr) {
            if(sideSize > 1) {
                let _2dArr = [];
                while(arr.length) _2dArr.push(arr.splice(0,sideSize));
                return _2dArr
            }
            else {
                return arr;
            }
        } */


        let grid = new Array(sideSize);
        for(let i = 0; i < grid.length; i++) {
            grid[i] = new Array(sideSize)
        }


        for(let x = 0; x < grid.length; x++) {
            for(let y = 0; y < grid.length; y++) {
                grid[x][y] = {x: x, 
                            y: y, 
                            parent: null,
                            g: 0,
                            h: 0,
                            f: 0,
                            visited: false,
                            closed: false,
                            };
            }
        }


        function astar(grid, start, end) {

            let openList = [];
            openList.push(grid[start.x][start.y]);
            //console.log(openList[0]);

            while(openList.length > 0) {

                currentNode = openList.pop();

                if(currentNode.x === end.x && currentNode.y === end.y) {
                    let curr = currentNode;
                    let ret = [start];
                    while(curr.parent) {
                        ret.push(curr);
                        curr = curr.parent;
                    }
                    return ret.reverse();
                }

                currentNode.closed = true

                let neighbours = findNeighbours(grid, currentNode.x, currentNode.y);
                

                for(let i=0, il = neighbours.length; i < il; i++) {
                    let neighbour = neighbours[i];

                    if(neighbour.closed) {
                        continue;
                    }

                    let gScore = currentNode.g + heuristic(neighbour.x, neighbour.y, end.x, end.y);
                    let beenVisited = neighbour.visited;

                    //console.log(neighbour)
                    if(!beenVisited || gScore < neighbour.g) {


                        neighbour.visited = true;
                        neighbour.parent = currentNode;
                        neighbour.h = neighbour.h || heuristic(neighbour.x, neighbour.y, end.x, end.y)
                        neighbour.g = gScore;
                        neighbour.f = neighbour.g + neighbour.h
                        

                        if(!beenVisited) {
                            openList.push(neighbour)
                        }
                        openList.unshift(openList.splice(openList.indexOf(neighbour), 1)[0])
                    }
                }
            }
            return [];
        }

        function array_move(arr, fromIndex, toIndex) {
            let element = arr[fromIndex];
            arr.splice(fromIndex, 1);
            arr.splice(toIndex, 0, element)
        }

        function heuristic(aPosX, aPosY, bPosX, bPosY) {
            let d1 = Math.abs(bPosX - aPosX)
            let d2 = Math.abs(bPosY - aPosY)
            return d1 * d2
        }

        function findNeighbours(grid, xPos, yPos) {
            let rowLimit = grid.length - 1;
            let columnLimit = grid[0].length - 1;
            let returnArr = [];

            for(let x = Math.max(0, xPos-1); x <= Math.min(xPos+1, rowLimit); x++) {
                for(let y = Math.max(0, yPos-1); y <= Math.min(yPos+1, columnLimit); y++) {
                    if(x !== xPos || y !== yPos) {
                        returnArr.push(grid[x][y])
                    }
                }
            }
            return returnArr;
        }

        //Temp
        let start = {x: 2, y: 5};
        let end = {x: 0, y: 0};


        /* function createGrid(sideScale) {
            for(let rows = 0; rows < sideScale; rows++) {
                let containerDiv = document.createElement('div');
                containerDiv.className = "containerDiv"
                for(let cols = 0; cols < sideScale; cols++) {

                    let pos = {x: rows, y:cols}

                    let item = document.createElement('div');
                    item.innerHTML = `${pos.x} , ${pos.y}`;
                    item.style.border = "1px solid black"
                    item.style.width = "max-content"
                    item.style.padding = "3px"

                    for(let i = 0; i < path.length; i++) {
                        if(pos.x === path[i].x && pos.y === path[i].y) {
                            item.style.backgroundColor = "aqua"
                        }

                    }
                    containerDiv.appendChild(item)
                }
                document.getElementById('container').append(containerDiv)
            }
        } */
    </script>
</body>

</html>