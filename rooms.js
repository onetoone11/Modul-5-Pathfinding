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
    constructor(id, exits) {
        this.id = id;
        this.name = names();
        this.exits = exits;
    }

    name() {
        return this.name;
    }

    exits() {
        return this.exits;
    }

    id() {
        return this.id;
    }
}

const mod = (a,b) => {
    return a - b * Math.floor(a/b);
}

const neighbours = [
    [1,0],
    [0,1],
    [-1,0],
    [0,-1]
]

class World {
    constructor(name, length) {
        this.name = name;
        this.rooms = {};
        this.length = length;
    }

    length() {
        return this.rooms.length;
    }

    createStringRooms() {
        for(let i = 0; i < this.length; i++) {
            let temp = new Room(i, [(i+1) === this.length ? null : i+1, (i-1) === -1 ? null : i-1].filter(element => element !== null));
            this.rooms[temp.id] = temp;
        }
    }

    createCircularRooms() {
        for(let i = 0; i < this.length; i++) {
            let temp = new Room(i, [mod(i+1, this.length), mod(i-1, this.length)]);
            this.rooms[temp.id] = temp;
        }
    }

    to1D(x, y, rowlength) {
        return (y * rowlength) + x;
    }

    createSquareRoom(sideLength) {
        for(let x = 0; x < sideLength; x++) {
            for(let y = 0; y < sideLength; y++) {
                let temp = new Room(this.to1D(x, y, sideLength), 
                neighbours.map(element => (x + element[0] < 0 || x + element[0] >= sideLength || y + element[1] < 0 || y + element[1] >= sideLength) ? null : this.to1D(x + element[0], y + element[1], sideLength)).filter(element => element !== null) );
                this.rooms[temp.id] = temp;
            }
        }
    }

    getRoom(id) {
        return this.rooms[id];
    }
}