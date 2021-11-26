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

const mod = (a, b) => {
    return a - b * Math.floor(a / b);
}

const neighbours = [
    [1, 0],
    [0, 1],
    [-1, 0],
    [0, -1]
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
        for (let i = 0; i < this.length; i++) {
            let temp = new Room(i, [(i + 1) === this.length ? null : i + 1, (i - 1) === -1 ? null : i - 1].filter(element => element !== null));
            this.rooms[temp.id] = temp;
        }
    }

    createCircularRooms() {
        for (let i = 0; i < this.length; i++) {
            let temp = new Room(i, [mod(i + 1, this.length), mod(i - 1, this.length)]);
            this.rooms[temp.id] = temp;
        }
    }

    to1D(x, y, rowlength) {
        return (y * rowlength) + x;
    }

    createSquareRoom(sideLength) {
        for (let x = 0; x < sideLength; x++) {
            for (let y = 0; y < sideLength; y++) {
                let temp = new Room(this.to1D(x, y, sideLength),
                    neighbours.map(element => (x + element[0] < 0 || x + element[0] >= sideLength || y + element[1] < 0 || y + element[1] >= sideLength) ? null : this.to1D(x + element[0], y + element[1], sideLength)).filter(element => element !== null));
                this.rooms[temp.id] = temp;
            }
        }
    }

    createBranchedRoom(lengthOfMainBranch) {
        const count = a => {
            if (a < 5) {
                return [];
            } else {
                return [a, ...count(Math.floor(a * 0.7))];
            }
        }
        let branches = count(lengthOfMainBranch);
        let diffArray = [];
        let randAwway = [];

        for (let i = 0; i < branches.length - 1; i++) {
            diffArray[i] = Math.abs(branches[i + 1] - branches[i]);
            randAwway[i] = Math.floor(Math.abs(diffArray[i]*Math.random()));
        }


        // console.log(branches, diff, rndm);

        let cur_id = 0;

        for (let i = 0; i < branches.length; i++) {
            for (let j = 0; j < branches[i]; j++) {
                j + cur_id;
                let temp;
                if(j === randAwway[i]) {
                    temp = new Room(j + cur_id, [(j + 1) === branches[i] ? null : j + cur_id + 1, (j - 1) === -1 ? null : j + cur_id - 1, cur_id + branches[i]].filter(element => element !== null));
                } else {
                    temp = new Room(j + cur_id, [(j + 1) === branches[i] ? null : j + cur_id + 1, (j - 1) === -1 ? null : j + cur_id - 1].filter(element => element !== null));
                }
                this.rooms[temp.id] = temp;
            }
            cur_id += branches[i];
        }
        console.log(randAwway, diffArray)




        // if (lengthOfMainBranch < 5) {
        //     return [];
        // } else {
        //     for (let i = count; i < lengthOfMainBranch + count; i++) {
        //         let temp = new Room(i, );
        //         this.rooms[temp.id] = temp;
        //     }
        //     // return [lengthOfMainBranch,...this.createBranchedRoom(Math.floor(lengthOfMainBranch * 0.7))]
        //     return this.createBranchedRoom([lengthOfMainBranch, ])
        // }
    }

    getRoom(id) {
        return this.rooms[id];
    }
}

let world = {
    "1": {
        name: "dkjkjkd"
    }
}