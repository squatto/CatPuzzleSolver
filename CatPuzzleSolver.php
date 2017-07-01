<?php

class CatPuzzleSolver
{
    protected $tiles = [];
    protected $rotations = [];
    protected $checks = [];
    protected $connections = [];

    public function __construct()
    {
        define('SCRIPT_START', microtime(true));
        $this->setup();
        $this->solve();
    }

    /**
     * Set up the tiles, rotations, and solution checks
     */
    private function setup()
    {
        // tile positions
        define('POS_TOP', 0);
        define('POS_RIGHT', 1);
        define('POS_BOTTOM', 2);
        define('POS_LEFT', 3);

        // tiles
        define('PINK_HEAD', 1);
        define('PINK_FOOT', 2);
        define('GREEN_HEAD', 3);
        define('GREEN_FOOT', 4);
        define('ORANGE_HEAD', 5);
        define('ORANGE_FOOT', 6);
        define('BLUE_HEAD', 7);
        define('BLUE_FOOT', 8);

        // starting cat card tiles
        $this->tiles = [
            1 => [PINK_FOOT, GREEN_FOOT, ORANGE_HEAD, BLUE_HEAD],  // 1, 2, 3, 4
            2 => [PINK_FOOT, ORANGE_FOOT, BLUE_HEAD, GREEN_HEAD],  // 5, 6, 7, 8
            3 => [PINK_FOOT, GREEN_FOOT, ORANGE_HEAD, BLUE_HEAD],  // 9, 10, 11, 12
            4 => [PINK_FOOT, BLUE_FOOT, ORANGE_HEAD, BLUE_HEAD],   // 13, 14, 15, 16
            5 => [BLUE_FOOT, PINK_HEAD, GREEN_HEAD, ORANGE_FOOT],  // 17, 18, 19, 20
            6 => [PINK_FOOT, BLUE_FOOT, ORANGE_HEAD, GREEN_HEAD],  // 21, 22, 23, 24
            7 => [BLUE_HEAD, GREEN_FOOT, ORANGE_FOOT, PINK_HEAD],  // 25, 26, 27, 28
            8 => [ORANGE_FOOT, GREEN_FOOT, PINK_HEAD, GREEN_HEAD], // 29, 30, 31, 32
            9 => [GREEN_HEAD, BLUE_HEAD, ORANGE_FOOT, PINK_FOOT],  // 33, 34, 35, 36
        ];

        // store the rotations for each cat card tile
        $this->rotations = [];

        foreach ($this->tiles as $idx => $colors) {
            $this->rotations[$idx] = [];

            for ($i = 1; $i <= 4; $i++) {
                $this->rotations[$idx][$i] = $colors;
                $color = array_pop($colors);
                array_unshift($colors, $color);
            }
        }

        // solution checks
        // e.g. card 1 right must match card 2 left
        $this->checks = [
            [1, POS_RIGHT, 2, POS_LEFT],
            [2, POS_RIGHT, 3, POS_LEFT],
            [1, POS_BOTTOM, 4, POS_TOP],
            [2, POS_BOTTOM, 5, POS_TOP],
            [3, POS_BOTTOM, 6, POS_TOP],
            [4, POS_RIGHT, 5, POS_LEFT],
            [5, POS_RIGHT, 6, POS_LEFT],
            [4, POS_BOTTOM, 7, POS_TOP],
            [5, POS_BOTTOM, 8, POS_TOP],
            [6, POS_BOTTOM, 9, POS_TOP],
            [7, POS_RIGHT, 8, POS_LEFT],
            [8, POS_RIGHT, 9, POS_LEFT],
        ];

        // valid connections
        $this->connections = [
            PINK_HEAD   => PINK_FOOT,
            PINK_FOOT   => PINK_HEAD,
            ORANGE_HEAD => ORANGE_FOOT,
            ORANGE_FOOT => ORANGE_HEAD,
            BLUE_HEAD   => BLUE_FOOT,
            BLUE_FOOT   => BLUE_HEAD,
            GREEN_HEAD  => GREEN_FOOT,
            GREEN_FOOT  => GREEN_HEAD,
        ];
    }

    /**
     * Get the current execution time
     *
     * @return string
     */
    private function getTime()
    {
        $total = floor(microtime(true) - SCRIPT_START);
        $hours = floor($total / (60 * 60));
        $minutes = floor(($total - ($hours * 60 * 60)) / 60);
        $seconds = ($total % 60);

        return "$hours hours $minutes minutes $seconds seconds";
    }

    /**
     * Solve the puzzle
     * This could be done more efficiently with recursion, I'm sure,
     * but it's quite efficient already (it finds four solutions in
     * less than one second!)
     */
    public function solve()
    {
        $checkedCount = 0;

        for ($tile1 = 1; $tile1 <= 36; $tile1++) {
            for ($tile2 = 1; $tile2 <= 36; $tile2++) {
                $checkedCount++;

                if (! $this->validSet([$tile1, $tile2])) {
                    continue;
                }

                for ($tile3 = 1; $tile3 <= 36; $tile3++) {
                    $checkedCount++;

                    if (! $this->validSet([$tile1, $tile2, $tile3])) {
                        continue;
                    }

                    for ($tile4 = 1; $tile4 <= 36; $tile4++) {
                        $checkedCount++;

                        if (! $this->validSet([$tile1, $tile2, $tile3, $tile4])) {
                            continue;
                        }

                        for ($tile5 = 1; $tile5 <= 36; $tile5++) {
                            $checkedCount++;

                            if (! $this->validSet([$tile1, $tile2, $tile3, $tile4, $tile5])) {
                                continue;
                            }

                            for ($tile6 = 1; $tile6 <= 36; $tile6++) {
                                $checkedCount++;

                                if (! $this->validSet([$tile1, $tile2, $tile3, $tile4, $tile5, $tile6])) {
                                    continue;
                                }

                                for ($tile7 = 1; $tile7 <= 36; $tile7++) {
                                    $checkedCount++;

                                    if (! $this->validSet([$tile1, $tile2, $tile3, $tile4, $tile5, $tile6, $tile7])) {
                                        continue;
                                    }

                                    for ($tile8 = 1; $tile8 <= 36; $tile8++) {
                                        $checkedCount++;

                                        if (! $this->validSet([
                                            $tile1,
                                            $tile2,
                                            $tile3,
                                            $tile4,
                                            $tile5,
                                            $tile6,
                                            $tile7,
                                            $tile8,
                                        ])
                                        ) {
                                            continue;
                                        }

                                        for ($tile9 = 1; $tile9 <= 36; $tile9++) {
                                            $checkedCount++;

                                            $combo = [
                                                $tile1,
                                                $tile2,
                                                $tile3,
                                                $tile4,
                                                $tile5,
                                                $tile6,
                                                $tile7,
                                                $tile8,
                                                $tile9,
                                            ];

                                            if ($tiles = $this->validSet($combo)) {
                                                $checkedCount++;

                                                echo '----------' . PHP_EOL;
                                                echo 'FOUND A SOLUTION!' . PHP_EOL;
                                                echo "checked count: $checkedCount" . PHP_EOL;
                                                echo $this->getTime() . PHP_EOL;

                                                $this->showSolution($combo, $tiles);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Is the tile set valid?
     *
     * @param array $set
     *
     * @return array|bool
     */
    private function validSet($set)
    {
        // are there any duplicates? it's invalid if so
        if (array_unique($set) != $set) {
            return false;
        }

        // are any of the tiles from the same card? it's invalid if so
        foreach ($set as $idx1 => $number1) {
            $min = floor($number1 / 4) * 4 + 1;
            $max = $min + 3;

            foreach ($set as $idx2 => $number2) {
                if ($idx1 != $idx2 && $number2 >= $min && $number2 <= $max) {
                    return false;
                }
            }
        }

        // we're looking at unique cards
        // check the connections
        return $this->checkCombination($set);
    }

    /**
     * Check the connections in the tile combination
     *
     * @param array $combo
     *
     * @return array|bool
     */
    private function checkCombination($combo)
    {
        /*
        checks:
        row 1:      1-2, 2-3
        row 1 to 2: 1-4, 2-5, 3-6
        row 2:      4-5, 5-6
        row 2 to 3: 4-7, 5-8, 6-9
        row 3:      7-8, 8-9

        +---+---+---+
        | 1 | 2 | 3 |
        +---+---+---+
        | 4 | 5 | 6 |
        +---+---+---+
        | 7 | 8 | 9 |
        +---+---+---+
        */

        // $combo can contain 2-9 numbers
        // we validate the tiles up to the provided count
        $tiles = $this->getTiles($combo);

        foreach ($this->checks as $check) {
            list($index1, $pos1, $index2, $pos2) = $check;

            if (! isset($tiles[$index1]) || ! isset($tiles[$index2])) {
                // one of the tiles doesn't exist yet, so we can't check this connection
                break;
            }

            $tile1 = $tiles[$index1][$pos1];
            $tile2 = $tiles[$index2][$pos2];

            if ($this->connections[$tile1] != $tile2) {
                // incorrect connection, so this entire combo is invalid
                return false;
            }
        }

        // we've solved it if we checked all 9 tiles
        // in other words, count($tiles)==9
        return $tiles;
    }

    /**
     * Given a combination set (2-9 tiles, each are 1-36)
     * return the cards with the correct rotation
     *
     * @param array $combo
     *
     * @return array
     */
    private function getTiles($combo)
    {
        $tiles = [];

        foreach ($combo as $idx => $tile) {
            $index = (int) floor(($tile - 1) / 4) + 1;
            $rotation = (($tile - 1) % 4) + 1;
            $tiles[$idx + 1] = $this->rotations[$index][$rotation];
        }

        return $tiles;
    }

    /**
     * Given a combination and tiles set, display the solution
     *
     * @param array $combo
     * @param array $tiles
     */
    public function showSolution($combo, $tiles)
    {
        echo '$combo:';
        print_r($combo);
        echo PHP_EOL;

        foreach ($tiles as $index => $tile) {
            $tileNumber = (int) floor(($combo[$index - 1] - 1) / 4) + 1;
            echo "    [tile $index : card $tileNumber]" . PHP_EOL;
            echo '       ' . $this->getName($tile[0]) . PHP_EOL;
            echo $this->getName($tile[3]) . '   ' . $this->getName($tile[1]) . PHP_EOL;
            echo '       ' . $this->getName($tile[2]) . PHP_EOL;
            echo PHP_EOL;
        }
    }

    /**
     * Get the name of a card position
     * This is used while displaying a solution, so it's formatted for it
     *
     * @param int $value
     *
     * @return string
     */
    public function getName($value)
    {
        $names = [
            1 => ' PINK_HEAD ',
            2 => ' PINK_FOOT ',
            3 => ' GREEN_HEAD',
            4 => ' GREEN_FOOT',
            5 => 'ORANGE_HEAD',
            6 => 'ORANGE_FOOT',
            7 => ' BLUE_HEAD ',
            8 => ' BLUE_FOOT ',
        ];

        return $names[$value];
    }
}

// instantiate the solver and solve the puzzle
$solver = new CatPuzzleSolver;
