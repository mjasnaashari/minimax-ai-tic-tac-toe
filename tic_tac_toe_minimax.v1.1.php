<?php

/*
    |------------------------------------------------------
    | Function to initialize the board dynamically
    |------------------------------------------------------
    |
*/
function initializeBoard($size): array
{
    return array_fill(0, $size, array_fill(0, $size, " "));
}

// Function to print the board
function printBoard($board): void
{
    $size = count($board);
    echo str_repeat("-", $size * 4) . "\n";
    foreach ($board as $row) {
        echo "| " . implode(" | ", $row) . " |\n";
        echo str_repeat("-", $size * 4) . "\n";
    }
}

/*
    |------------------------------------------------------
    | Function to check if a player has won
    |------------------------------------------------------
    |
*/
function checkWinner($board, $player): bool
{
    $size = count($board);

    // Check rows
    foreach ($board as $row) {
        if (count(array_unique($row)) === 1 && $row[0] === $player) {
            return true;
        }
    }

    // Check columns
    for ($col = 0; $col < $size; $col++) {
        $colArray = array_column($board, $col);
        if (count(array_unique($colArray)) === 1 && $colArray[0] === $player) {
            return true;
        }
    }

    // Check diagonals
    $diag1 = $diag2 = [];
    for ($i = 0; $i < $size; $i++) {
        $diag1[] = $board[$i][$i];
        $diag2[] = $board[$i][$size - $i - 1];
    }

    if ((count(array_unique($diag1)) === 1 && $diag1[0] === $player) ||
        (count(array_unique($diag2)) === 1 && $diag2[0] === $player)) {
        return true;
    }

    return false;
}

/*
    |------------------------------------------------------
    | Function to check if the game is a tie
    |------------------------------------------------------
    |
*/
function isTie($board): bool
{
    foreach ($board as $row) {
        if (in_array(" ", $row)) {
            return false;
        }
    }
    return true;
}

/*
    |------------------------------------------------------
    | Minimax algorithm with alpha-beta pruning
    |------------------------------------------------------
    |
*/
function minimax(&$board, $depth, $isMaximizing, $maxDepth, $size)
{
    $criterion = $size * $size;

    if (checkWinner($board, "O")) {
        return $criterion - $depth;
    }
    if (checkWinner($board, "X")) {
        return -$criterion + $depth;
    }
    if (isTie($board) || $depth >= $maxDepth) {
        return 0;
    }

    // for AI
    if ($isMaximizing) {
        $bestScore = -PHP_INT_MAX;

        for ($row = 0; $row < $size; $row++) {
            for ($column = 0; $column < $size; $column++) {
                if ($board[$row][$column] === " ") {
                    $board[$row][$column] = "O";
                    $score = minimax($board, $depth + 1, false, $maxDepth, $size);

                    $board[$row][$column] = " ";
                    $bestScore = max($bestScore, $score);
                }
            }
        }

        return $bestScore;
        // for Player
    } else {
        $bestScore = PHP_INT_MAX;

        for ($row = 0; $row < $size; $row++) {
            for ($column = 0; $column < $size; $column++) {
                if ($board[$row][$column] === " ") {
                    $board[$row][$column] = "X";
                    $score = minimax($board, $depth + 1, true, $maxDepth, $size);

                    $board[$row][$column] = " ";
                    $bestScore = min($bestScore, $score);
                }
            }
        }

        return $bestScore;
    }
}

/*
    |------------------------------------------------------
    | Function for AI to choose the best move
    |------------------------------------------------------
    |
*/
function aiMove(&$board, $maxDepth): array
{
    $bestScore = -PHP_INT_MAX;
    $bestMove = [-1, -1];
    $size = count($board);

    for ($row = 0; $row < $size; $row++) {
        for ($column = 0; $column < $size; $column++) {
            if ($board[$row][$column] === " ") {
                $board[$row][$column] = "O";
                $score = minimax(board: $board, depth: 0, isMaximizing: false, maxDepth: $maxDepth, size: $size);

                $board[$row][$column] = " ";
                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestMove = [$row, $column];
                }
            }
        }
    }

    return $bestMove;
}

/*
    |------------------------------------------------------
    | Main Tic-Tac-Toe function
    |------------------------------------------------------
    |
    |   * Set board size -> initialize
    |   * Set max depth for AI
    |   * Set players movements
    |   * Check winner or tie!
    |
*/
function ticTacToe(): void
{
    echo "Enter board size (e.g., 3 for 3x3): ";
    $size = (int)trim(fgets(STDIN));
    $board = initializeBoard($size);

    echo "Enter max depth for AI calculation (e.g., 5): ";
    $maxDepth = (int)trim(fgets(STDIN));

    $currentPlayer = "X";

    for ($turn = 0; $turn < $size * $size; $turn++) {
        printBoard($board);

        if ($currentPlayer === "X") {
            while (true) {
                echo "Enter row and column (0-" . ($size - 1) . "): ";
                $input = trim(fgets(STDIN));
                $parts = explode(" ", $input);

                if (count($parts) === 2) {
                    list($row, $col) = $parts;

                    if (is_numeric($row) && is_numeric($col) &&
                        $row >= 0 && $row < $size &&
                        $col >= 0 && $col < $size &&
                        $board[$row][$col] === " ") {
                        break;
                    } else {
                        echo "Invalid move. Please try again.\n";
                    }
                } else {
                    echo "Invalid input. Please try again.\n";
                }
            }
        } else {
            list($row, $col) = aiMove($board, $maxDepth);
            echo "AI plays $row, $col\n";
        }

        $board[$row][$col] = $currentPlayer;

        if (checkWinner($board, $currentPlayer)) {
            printBoard($board);
            echo "$currentPlayer wins!\n";
            return;
        }

        $currentPlayer = $currentPlayer === "X" ? "O" : "X";
    }

    printBoard($board);
    echo "It's a tie!\n";
}

// Run the game
ticTacToe();
