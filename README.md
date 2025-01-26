# Minimax AI Tic-Tac-Toe

Minimax AI Tic-Tac-Toe is a dynamic and intelligent implementation of the classic Tic-Tac-Toe game in PHP. This project features a scalable game board, a smart AI opponent, and the **Minimax algorithm** for making optimal moves during gameplay.

---

## Features

- **Dynamic Board Size:** Supports customizable board sizes (e.g., 3x3, 4x4, etc.).
- **Minimax Algorithm:** Implements a recursive decision-making algorithm to calculate optimal moves for the AI.
- **Customizable Difficulty:** Allows users to define the maximum depth for the AI's calculation.
- **Player vs AI:** Play against an intelligent AI opponent.
- **Handles Edge Cases:** Detects wins, ties, and invalid moves robustly.

---

## How It Works

1. **Initialization:**
    - The game starts by prompting the user to input the desired board size and the maximum depth for the AI.

2. **Game Flow:**
    - Players alternate turns starting with "X" (human player).
    - The AI calculates its moves using the Minimax algorithm.

3. **End Game:**
    - The game ends when there is a winner or the board is filled (tie).

---

## Usage

1. Clone the repository:
   ```bash
   git clone https://github.com/mjasnaashari/minimax-ai-tic-tac-toe

2. Navigate to the project directory:
    ```bash
   cd minimax-ai-tic-tac-toe
   
3. Run the script:
    ```bash
   php tic_tac_toe_minimax.v1.1.php
