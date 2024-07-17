<?php

class BlackjackGame {
    protected $deck;
    protected $playerHand;
    protected $dealerHand;

    public function __construct() {
        $this->deck = $this->createDeck();
        shuffle($this->deck);
        $this->playerHand = [];
        $this->dealerHand = [];
    }

    // Create deck
    protected function createDeck() {
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
        $deck = [];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $deck[] = ['suit' => $suit, 'value' => $value];
            }
        }

        return $deck;
    }

    // Deal Card
    protected function dealCard() {
        return array_pop($this->deck);
    }

    // Calculate hand value
    protected function calculateHandValue($hand) {
        $value = 0;
        $aces = 0;

        foreach ($hand as $card) {
            if (is_numeric($card['value'])) {
                $value += $card['value'];
            } elseif ($card['value'] == 'A') {
                $aces++;
                $value += 11; // inicialmente, conte os ases como 11
            } else {
                $value += 10;
            }
        }

        while ($value > 21 && $aces > 0) {
            $value -= 10; // ajuste os ases de 11 para 1 se estourar 21
            $aces--;
        }

        return $value;
    }

    // Start game
    public function startGame() {
        $this->playerHand[] = $this->dealCard();
        $this->playerHand[] = $this->dealCard();
        $this->dealerHand[] = $this->dealCard();
        $this->dealerHand[] = $this->dealCard();
    }

    // Player get card
    public function hit() {
        $this->playerHand[] = $this->dealCard();
        return $this->calculateHandValue($this->playerHand);
    }

    // Player stand
    public function stand() {
        while ($this->calculateHandValue($this->dealerHand) < 17) {
            $this->dealerHand[] = $this->dealCard();
        }

        $playerValue = $this->calculateHandValue($this->playerHand);
        $dealerValue = $this->calculateHandValue($this->dealerHand);

        if ($playerValue > 21) {
            return 'Player busts!';
        } elseif ($dealerValue > 21 || $playerValue > $dealerValue) {
            return 'Player wins!';
        } elseif ($playerValue < $dealerValue) {
            return 'Dealer wins!';
        } else {
            return 'Push (tie)!';
        }
    }

    // Get player hand
    public function getPlayerHand() {
        return $this->playerHand;
    }

    // Get dealer hand
    public function getDealerHand() {
        return $this->dealerHand;
    }
}

// Example
$game = new BlackjackGame();
$game->startGame();
echo "Player's hand: ";
print_r($game->getPlayerHand());
echo "Dealer's hand: ";
print_r($game->getDealerHand());

// Player decides to hit
$playerValue = $game->hit();
echo "Player hits: New hand value = $playerValue\n";

// Player decides to stand
$result = $game->stand();
echo $result;
