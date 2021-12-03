const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

let arrayRandom = new Array(100).fill('').map(element => [Math.random(), Math.random()]);

let x = 0;
let y = 0;

let isClicking = false;

let hasClicked = false;

canvas.addEventListener('mousemove', e => {
    x = e.offsetX;
    y = e.offsetY;
});

canvas.addEventListener('mousedown', e => {
    isClicking = true;
    hasClicked = true;
});

canvas.addEventListener('mouseup', e => {
    isClicking = false;
});

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

let circleArray = new Array(20).fill('').map((element, index) =>
    Circle(600 * arrayRandom[index][0], 600 * arrayRandom[index][1], 20)
    // new Array(5).fill('').map((e,i) => i)
    // [Math.floor(10*arrayRandom[index][1]),Math.floor(10*arrayRandom[index][0])]
);

/*
for every circle in array:
check if mouse is hovering over it(using the isInside function)
check if mouse is clicking(using the isClicking variable)
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

let arrtest = [0, 0];

function addLines() {
    for (let i = 0; i < circleArray.length; i++) {
        if (circleArray[i].switch) {
            arrtest = [arrtest[1], i];
            addExits(circleArray, arrtest[0], arrtest[1]);
            circleArray[i].switch = false;
        }
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
        if (isInsideCircle(x, y, circleArray[i].x, circleArray[i].y, circleArray[i].radius)) {
            if (hasClicked && !circleArray[i].switch) {
                circleArray[i].switch = true;
                hasClicked = false;
            }
            if (hasClicked && circleArray[i].switch) {
                circleArray[i].switch = false;
                hasClicked = false;
            }
        }
        if (circleArray[i].switch) {
            ctx.fillStyle = "red";
        } else {
            ctx.fillStyle = "blue";
        }
        circleDraw(circleArray[i].x, circleArray[i].y, circleArray[i].radius);
    }
}



function render(timestamp) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < circleArray.length; i++) {
        circleArray[i].x += 10 * Math.random() - 5;
        circleArray[i].y += 10 * Math.random() - 5;
    }

    addLines();
    drawLines();
    drawCircles();


    ctx.fill();

    requestAnimationFrame(render);
}
requestAnimationFrame(render);

var inputs = document.getElementById("create_world").elements;
console.log(inputs);













// const vertexShaderSource = `
// attribute vec4 a_position;

// void main() {
//     gl_Position = a_position;
// }
// `;

// const fragmentShaderSource = `
// #ifdef GL_ES
// precision mediump float;
// #endif

// uniform vec2 u_resolution;
// uniform float u_time;

// void main(){
//     vec2 uv = (gl_FragCoord.xy/u_resolution)-.5;
//     uv.x *= u_resolution.x/u_resolution.y;

//     vec3 color = vec3(1.0, 0.0, 1.0);
//     gl_FragColor = vec4(gl_FragCoord.xy/u_resolution, 1.0, 1.0);
// }
// `;


// var InitDemo = function () {
//     console.log("this is working");

//     var canvas = document.getElementById("canvas");
//     var gl = canvas.getContext("webgl");

//     if (!gl) {
//         return;
//     }


//     canvas.width = window.innerWidth;
//     canvas.height = window.innerHeight;
//     gl.viewport(0, 0, window.innerWidth, window.innerHeight);

//     gl.clearColor(0, 0, 0, 0);
//     gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

//     function createShader(gl, type, source) {
//         var shader = gl.createShader(type);
//         gl.shaderSource(shader, source);
//         gl.compileShader(shader);
//         var success = gl.getShaderParameter(shader, gl.COMPILE_STATUS);
//         if (success) {
//             return shader;
//         }

//         console.log(gl.getShaderInfoLog(shader));
//         gl.deleteShader(shader);
//     }

//     var vertexShader = createShader(gl, gl.VERTEX_SHADER, vertexShaderSource);
//     var fragmentShader = createShader(gl, gl.FRAGMENT_SHADER, fragmentShaderSource);

//     function createProgram(gl, vertexShader, fragmentShader) {
//         var program = gl.createProgram();
//         gl.attachShader(program, vertexShader);
//         gl.attachShader(program, fragmentShader);
//         gl.linkProgram(program);
//         var success = gl.getProgramParameter(program, gl.LINK_STATUS);
//         if (success) {
//             return program;
//         }

//         console.log(gl.getProgramInfoLog(program));
//         gl.deleteProgram(program);
//     }

//     var program = createProgram(gl, vertexShader, fragmentShader);

//     var positionAttributeLocation = gl.getAttribLocation(program, "a_position");

//     var resolutionLocation = gl.getUniformLocation(program, "u_resolution");
//     var timeLocation = gl.getUniformLocation(program, "u_time");

//     var positionBuffer = gl.createBuffer();

//     gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);

//     gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([
//         -1, -1,
//         1, -1,
//         -1, 1,
//         -1, 1,
//         1, -1,
//         1, 1,
//     ]), gl.STATIC_DRAW);


//     function render(time) {
//         time *= 0.001;

//         gl.useProgram(program);

//         gl.enableVertexAttribArray(positionAttributeLocation);

//         gl.vertexAttribPointer(
//             positionAttributeLocation,
//             2,
//             gl.FLOAT,
//             false,
//             0,
//             0,
//         );

//         gl.uniform2f(resolutionLocation, gl.canvas.width, gl.canvas.height);
//         gl.uniform1f(timeLocation, time);

//         gl.drawArrays(
//             gl.TRIANGLES,
//             0,
//             6,
//         );


//         requestAnimationFrame(render);
//     }
//     requestAnimationFrame(render);
// }