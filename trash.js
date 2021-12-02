

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
const pop = next;
const push = Stack;
const isEmpty = a => a === false;

const listPathsDFS = graph => rootID => STACK => {
    let stack = Stack(rootID)(false);

    if(!isEmpty(stack)) {
        
    }
}