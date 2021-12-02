const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");


// function circle(x, y, radius) {
//     ctx.
// }
let arrayRandom = new Array(10).fill('').map(element => Math.random());

let x = 0;
let y = 0;

canvas.addEventListener('mousemove', e => {
      x = e.offsetX;
      y = e.offsetY;
});

canvas.addEventListener('mousedown', e => {
    x = e.offsetX;
    y = e.offsetY;
});

canvas.addEventListener('mouseup', e => {
    x = e.offsetX;
    y = e.offsetY;
});

function render(timestamp) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = 'rgb(0.0, 1.0, 1.0, 1.0)';    
    // ctx.fillRect(50-x,50-y,x+50,y+50);
    ctx.beginPath();
    // ctx.arc(100*Math.cos(200)+canvas.width/2, 100*Math.sin(200)+canvas.height/2, 25, 0, 2 * Math.PI);
    // ctx.arc(100*Math.cos(200 + 1)+canvas.width/2, 100*Math.sin(200 + 1)+canvas.height/2, 25, 0, 2 * Math.PI);
    // ctx.arc(100*Math.cos(timestamp/100)+canvas.width/2, 100*Math.sin(timestamp/100)+canvas.height/2, 50, 0, 2 * Math.PI);
    // ctx.arc(100*Math.cos(timestamp/200)+canvas.width/2, 100*Math.sin(timestamp/200)+canvas.height/2, 50, 0, 2 * Math.PI);
    // for(let i = 0; i < 10; i++) {
        
    // // ctx.arc(100*Math.cos(timestamp/(1000*arrayRandom[i]) + i)+canvas.width/2, 100*Math.sin(timestamp/(1000*arrayRandom[i]) + i)+canvas.height/2, 10, 0, 2 * Math.PI);
    
    // ctx.closePath();    
    // }

    ctx.arc(x, y, 20, 0, 2 * Math.PI);
    ctx.closePath();

    ctx.fill();
    // ctx.beginPath();
    // ctx.moveTo(0, 0);
    // ctx.lineTo(300, 150);
    // ctx.stroke();
    

    requestAnimationFrame(render);
}
requestAnimationFrame(render);

canvas.addEventListener('mousemove', mouseEvent);

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