var adjective = [
    "big",
    "colossal",
    "fat",
    "gigantic",
    "great",
    "huge",
    "immense",
    "large",
    "microscopic",
    "teeny"
];

var locationn = [
    "hallway",
    "corridor",
    "dungeon",
    "cave",
    "church",
    "swamp",
    "lake",
    "graveyard",
    "bush",
    "school"
];

var abstractnoun = [
    "disquiet",
    "poverty",
    "failure",
    "stupidity",
    "weakness",
    "rhythm",
    "relaxation",
    "strength",
    "sorrow",
    "birthday"
];

const names = () => {
    return "A " + adjective[Math.floor(Math.random() * adjective.length)] + " " + locationn[Math.floor(Math.random() * locationn.length)] + " of " + abstractnoun[Math.floor(Math.random() * abstractnoun.length)];
}

class Room {
    constructor(id) {
        this.id = id;
        this.name = names();
        this.exits = [];
    }

    name() {
        return this.name;
    }

    exits() {
        return this.exits;
    }

    addExits(...exits) {
        this.exits.push(...exits);
    }

    id() {
        return this.id;
    }
}

const mod = (a, b) => {
    return a - b * Math.floor(a / b);
}

const neighbours = [
    [1, 0],
    [0, 1],
    [-1, 0],
    [0, -1]
]

// const arrayMake = val => func => {
//     if()
// }

class World {
    constructor(name, length) {
        this.name = name;
        this.rooms = [];
        this.length = length;
    }

    length() {
        return this.rooms.length;
    }

    createStringRooms(count = 0) {
        // for (let i = 0; i < this.length; i++) {
        //     let temp = new Room;
        //     if(i = 0) {

        //     }
        //     // (i, [(i + 1) === this.length ? null : i + 1, (i - 1) === -1 ? null : i - 1].filter(element => element !== null));
        //     this.rooms[temp.id] = temp;
        // }
        if(count === this.length)
            return [[count-1]];
        if(count === 0)
            return [[1], ...this.createStringRooms(count+1)];
        return [[count-1,count+1], ...this.createStringRooms(count+1)];
    }

    createCircularRooms() {
        for (let i = 0; i < this.length; i++) {
            this.rooms[i] = new Room(i, [mod(i + 1, this.length), mod(i - 1, this.length)]);
        }
    }

    to1D(x, y, rowlength) {
        return (y * rowlength) + x;
    }

    createSquareRoom(sideLength) {
        for (let x = 0; x < sideLength; x++) {
            for (let y = 0; y < sideLength; y++) {
                let temp = new Room(this.to1D(x, y, sideLength))
                temp.addExits(...neighbours.map(element => (x + element[0] < 0 || x + element[0] >= sideLength || y + element[1] < 0 || y + element[1] >= sideLength) ? null : this.to1D(x + element[0], y + element[1], sideLength)).filter(element => element !== null));
                this.rooms[temp.id] = temp;
            }
        }
    }

    createBranchedRoom(lengthOfMainBranch) {
        const count = a => (a < 5) ? [] : [a, ...count(Math.floor(a*0.7))];
        let branches = count(lengthOfMainBranch);
        let diffArray = [];
        let randAwway = [];

        for (let i = 0; i < branches.length - 1; i++) {
            diffArray[i] = Math.abs(branches[i + 1] - branches[i]);
            randAwway[i] = Math.floor(Math.abs(diffArray[i]*Math.random()));
        }

        let currentBranch = 0;

        for (let i = 0; i < branches.length; i++) {
            for (let j = 0; j < branches[i]; j++) {
                j + currentBranch;
                let temp;
                if(j === randAwway[i]) {
                    temp = new Room(j + currentBranch, [(j + 1) === branches[i] ? null : j + currentBranch + 1, (j - 1) === -1 ? null : j + currentBranch - 1, currentBranch + branches[i]].filter(element => element !== null));
                } else {
                    temp = new Room(j + currentBranch, [(j + 1) === branches[i] ? null : j + currentBranch + 1, (j - 1) === -1 ? null : j + currentBranch - 1].filter(element => element !== null));
                }
                this.rooms[temp.id] = temp;
            }
            currentBranch += branches[i];
        }
        console.log(randAwway, diffArray);
    }

    getRoom(id) {
        return this.rooms[id];
    }
}

// class StringWorld {
//     constructor(length) {
//         function createStringRooms(count = 0, length) {
//             // for (let i = 0; i < this.length; i++) {
//             //     let temp = new Room;
//             //     if(i = 0) {
    
//             //     }
//             //     // (i, [(i + 1) === this.length ? null : i + 1, (i - 1) === -1 ? null : i - 1].filter(element => element !== null));
//             //     this.rooms[temp.id] = temp;
//             // }
//             if(count === length)
//                 return [[count-1]];
//             if(count === 0)
//                 return [[1], ...createStringRooms(count+1)];
//             return [[count-1,count+1], ...createStringRooms(count+1)];
//         }
//         this.roomscreateStringRooms(0, length)
        
//     }
// }

const StringWorld = length => {
    if(length === 0) {
        return [];
    }
    StringWorld(length - 1);
    return 
}



// createStringRooms(count = 0) {

//     if(count === this.length) {
//         return [[count+1]];
//     }
//     if(count === 0) {
//         return [[1], ...this.createStringRooms(count+1)];
//     }
//     return [[count-1,count+1], ...this.createStringRooms(count+1)];
// }


class BranchedWorld {
    constructor(lengthOfMainBranch) {
        const count = a => (a < 5) ? [] : [a, ...count(Math.floor(a*0.7))];
        let branches = count(lengthOfMainBranch);
        const totalLength = branches.reduce((acc, cur) => acc + cur);

        this.rooms = new Array(totalLength).fill('').map((element, index) => new Room(index));
        
        let randAwway = [];
        for (let i = 0; i < branches.length - 1; i++) {
            randAwway[i] = Math.floor(Math.abs(Math.abs(branches[i + 1] - branches[i])*Math.random()));
        }

        let currentBranch = 0;

        for (let i = 0; i < branches.length; i++) {
            for (let j = 0; j < branches[i]; j++) {
                let currentPosition = j + currentBranch;
                if(j === 0)    //if in start position
                    this.rooms[currentPosition].addExits(currentPosition + 1);
                if(j > 0 && j < branches[i] - 1) 
                    this.rooms[currentPosition].addExits(currentPosition+1, currentPosition-1);
                if(j === branches[i] - 1)  //if on end of branch
                    this.rooms[currentPosition].addExits(currentPosition - 1);
                if(j === randAwway[i]) { //if 
                    this.rooms[currentPosition].addExits(currentBranch + branches[i]);
                    this.rooms[currentBranch + branches[i]].addExits(currentPosition);
                    this.rooms[currentPosition + branches[i+1]].addExits(currentBranch + branches[i] + branches[i+1] - 1);
                    this.rooms[currentBranch + branches[i] + branches[i+1] - 1].addExits(currentPosition);
                }
            }
            currentBranch += branches[i];
        }
        console.log(randAwway,branches);
    }
}


class Queue {
    constructor() {
        this.queue = [];
    }

    enqueue(item) {
        this.queue.push(item);
    }

    dequeue() {
        return this.queue.shift();
    }

    length() {
        return this.queue.length;
    }

    isEmpty() {
        return (this.queue.length === 0);
    }
}

const Stack = head => tail => f => f(head)(tail);
const TRUE = a => b => a;
const FALSE = a => b => b;
const value = a => a(TRUE);
const next = a => a(FALSE);
const popHead = next;

function BFS(graph, rootID) {
    let nodeQueue = new Queue();

    let visited = new Array(graph.rooms.length).fill(false);
    console.log(visited)

    nodeQueue.enqueue(rootID);

    let steps = 100;
    while(!nodeQueue.isEmpty() && steps > 0) {
        let currentNode = nodeQueue.dequeue();
        console.log(currentNode);

        if(visited[currentNode] === false) {
            visited[currentNode] = true;

            graph.rooms[currentNode].exits.map(element => {
                if(visited[element] === false) {
                    nodeQueue.enqueue(element);
                }
            })
        }
        steps--;
        
    }
    return visited;
}

function BFS2(graph, rootID) {
    let nodeQueue = new Queue();

    let visited = new Array(graph.rooms.length).fill(false);
    console.log(visited);
    visited[rootID] = true;

    nodeQueue.enqueue(rootID);

    let steps = 100;
    while(!nodeQueue.isEmpty() && steps > 0) {
        let currentNode = nodeQueue.dequeue();
        console.log(currentNode);

        // if(visited[currentNode] === false) {
        //     visited[currentNode] = true;

            graph.rooms[currentNode].exits.map(element => {
                if(visited[element] === false) {
                    visited[element] = true;
                    nodeQueue.enqueue(element);
                }
            });
        // }
        steps--;
        
    }
    return visited;
}
// [[0],[0,1],[0,6],[]]

// function BFS(graph, rootID) {

// }
function hasDuplicate(arr) {
    return new Set(arr).size !== arr.length
}

function listPathsBSF(graph, rootID, destination) {
    let pathQueue = new Queue();
    pathQueue.enqueue([rootID]);
    let pathList = [[rootID]];
    let steps = 200;
    while(!pathQueue.isEmpty() && steps > 0) {
        let currentPath = pathQueue.dequeue();
        graph.rooms[currentPath[currentPath.length-1]].exits.map(element => {
            pathQueue.enqueue([...currentPath, element]); //append this node to new path
            pathList.push([...currentPath, element]);
        });
        steps--;
    }
    return pathList;
}

function listPathsDFS(graph, rootID, destination) {

}


// function pathList2(graph, rootID, destination) {
//     let pathQueue = new Queue();

//     let visited = new Array(graph.rooms.length).fill(false);
//     console.log(visited)

//     pathQueue.enqueue(rootID);

//     let steps = 100;
//     while(!pathQueue.isEmpty() && steps > 0) {
//         let currentPath = pathQueue.dequeue();

//         if(visited[currentPath.at(-1)] === false) {
//             visited[currentPath.at(-1)] = true;

//             graph.rooms[currentPath].exits.map(element => {
//                 if(visited[element] === false) {
//                     pathQueue.enqueue(element);
//                     console.log(element);
//                 }
//             })
//         }
//         steps--;
        
//     }
//     return visited;
// }