var readline = require('readline');

var lines = []
var rl = readline.createInterface({
    input: process.stdin
});

rl.on('line', function (line) {
    lines.push(line)
});

rl.on('close', function () {
    solve(lines)
});

function solve(input) {
    let input = lines[0].split(' ');
    let a = Number(input[0]);
    let b = Number(input[1]);

    if (a === 0 && b === 0) {
        return;
    }

    if (a > b) {
        console.log(a);
    } else {
        console.log(b);
    }
};