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

function solve() {
    for (let i = 0; i < 100; i++) {
        if (i % 2 === 1) {
            console.log(i);
        }
    }
};

solve();