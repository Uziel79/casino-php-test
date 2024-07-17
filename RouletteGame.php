<?php
class RouletteGame
{
  protected $numbers = 37; // Europe Roulette (0-36)

  public function spin()
  {
    return rand(0, $this->numbers - 1);
  }

  public function calculatePayout($bet, $number)
  {
    $result = $this->spin();
    if ($result == $number) {
      return $bet * 35; // Pagamento 35:1
    } else {
      return 0;
    }
  }
}

// Example
$game = new RouletteGame();
$bet = 100; // 100 game
$number = 17; // Number choose

for ($i = 0;$i < 100;$i++) {
	$payout = $game->calculatePayout($bet, $number);
	echo "Result $i: $payout \n";
}

