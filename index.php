<?php
if (php_sapi_name() !== 'cli') {
    exit;
}

$player = ['y'=>4, 'x'=>1];
$maps = [
    ['#','#','#','#','#','#','#','#'], // 0
    ['#','.','.','.','.','.','.','#'], // 1
    ['#','.','#','#','#','.','.','#'], // 2
    ['#','.','.','.','#','.','#','#'], // 3
    ['#','.','#','.','.','.','.','#'], // 4
    ['#','#','#','#','#','#','#','#'], // 5
];
$treasure = ['y'=>1, 'x'=>6];

function updateMap($maps, $player) {
    foreach ($maps as $keyY => $y) {
        foreach ($y as $keyX => $x) {
            if ($player['y'] == $keyY && $player['x'] == $keyX) {
                echo 'X';
            } else {
                echo $x;
            }
        }
        echo "\n";
    }
}


echo "Find the treasure\n";
updateMap($maps, $player);

$moveup = false;
$moveright = false;
$movedown = false;

// system("stty -icanon");
while(true) {
    $key = fopen ("php://stdin","r");
    if ($moveup) {
        if ($moveright) {
            echo "\nStep Down : ";
            $step = fgetc($key);
            $to = 'down';
            $movedown = true;
        } else {
            echo "\nStep Right : ";
            $step = fgetc($key);
            $to = 'right'; 
            $moveright = true;
        }
    } else {
        echo "\nStep Up : ";
        $step = fgetc($key);
        $to = 'up';
        $moveup = true; 
    }
    // up
    for ($i = 0; $i < $step; $i++) {
        switch ($to) {
            case 'up':
                if ($maps[$player['y'] - 1][$player['x']] != '#') {
                    $player['y']--;
                }
                break;
            case 'right':
                if ($maps[$player['y']][$player['x'] + 1] != '#') {
                    $player['x']++;
                }
                break;
            case 'down':
                if ($maps[$player['y'] + 1][$player['x']] != '#') {
                    $player['y']++;
                }
                break;
            
            default:
                # code...
                break;
        }
        updateMap($maps, $player);
        usleep(500000);
    }

    if ($movedown) {
        echo "checking...\n";
        sleep(2);
        if ($treasure['y'] == $player['y'] && $treasure['x'] == $player['x']) {
            echo "CONGRATS, YOU FOUND A TREASURE\n\n";
        } else {
            echo "No treasure in this coordinate\n\n";
        }
        echo "Game Over!\n";
        break;
    }

    // if(trim($movement) == 'q'){
    //     echo "DONE!\n";
    //     break;
    // } elseif(trim($movement) == 'w') { // keatas
    //     $move = $player['y'] - 1;
    //     if ($maps[$player['y'] - 1][$player['x']] != '#') {
    //         $player['y'] = $player['y'] - 1;
    //     }
    // } elseif(trim($movement) == 'a') { // kekiri
    //     $move = $player['x'] - 1;
    //     if ($maps[$player['y']][$player['x'] - 1] != '#') {
    //         $player['x'] = $player['x'] - 1;
    //     }
    // } elseif(trim($movement) == 's') { // kebawah
    //     $move = $player['y'] + 1;
    //     if ($maps[$player['y'] + 1][$player['x']] != '#') {
    //         $player['y'] = $player['y'] + 1;
    //     }
    // } elseif(trim($movement) == 'd') { // kebawah
    //     $move = $player['x'] + 1;
    //     if ($maps[$player['y']][$player['x'] + 1] != '#') {
    //         $player['x'] = $player['x'] + 1;
    //     }
    // }
}