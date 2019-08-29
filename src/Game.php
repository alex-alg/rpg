<?php
namespace Src;

use Src\Characters\Hero;
use Src\Characters\Beast;
use Src\Characters\Character;
use Src\Characters\CharacterFactory;
use Src\Observers\MessageObservers\ActionObserver;
use Src\Observers\MessageObservers\SkillObserver;
use Src\Observers\MessageObservers\DamageObserver;
use Src\views\main;

class Game
{
	const MAX_TURNS = 20;

	public function init(): void
	{
		// set game
		$_SESSION['game_in_progress'] = true;
		$_SESSION['turn'] = 1;
		$_SESSION['message'] = 'Game initiated';

		// set characters
		$characterFactory = new CharacterFactory();

		$hero = $characterFactory->generateCharacter('hero', 'Carmack');
		$hero->attach(new ActionObserver())
			->attach(new SkillObserver())
			->attach(new DamageObserver());

		$beast = $characterFactory->generateCharacter('beast', 'Chupacabra');
		$beast->attach(new ActionObserver())
			->attach(new DamageObserver());

		$this->setFirstTurnCharacter($hero, $beast);

		$_SESSION['hero'] = $hero;
		$_SESSION['beast'] = $beast;
	}

	public function turn(): void
	{
		$hero = $_SESSION['hero'];
		$beast = $_SESSION['beast'];
		$_SESSION['message'] = '';

		//character execute attack
		(bool)$hero->getData('isTurn') ? $hero->attack($beast) : $beast->attack($hero);

		//get turn summary
		$hero->notify();
		$beast->notify();
		$hero->resetSpecialSkills();

		//change turns
		$hero->toggleTurn();
		$beast->toggleTurn();

		//update with latest values for next turn
		$_SESSION['hero'] = $hero;
		$_SESSION['beast'] = $beast;
		$_SESSION['turn']++;
	}

	public function setFirstTurnCharacter(Character $c1, Character $c2): void
	{
		if($c1->getData('speed') > $c2->getData('speed')){
			$c1->setData('isTurn', TRUE);
		}

		if($c1->getData('speed') < $c2->getData('speed')){
			$c2->setData('isTurn', TRUE);
		}

		if($c1->getData('luck') > $c2->getData('luck') && $c1->getData('speed') === $c2->getData('speed')){
			$c1->setData('isTurn', TRUE);
		}

		if($c1->getData('luck') < $c2->getData('luck') && $c1->getData('speed') === $c2->getData('speed')){
			$c2->setData('isTurn', TRUE);
		}
	}

	public function shouldEndGame(): bool
	{
		$flag = false;
		$hero = $_SESSION['hero'];
		$beast = $_SESSION['beast'];
		$turn = $_SESSION['turn'];

		if($hero->getData('health') <= 0 || $beast->getData('health') <= 0){
			$flag = true;
		}

		if($turn === self::MAX_TURNS){
			$flag = true;
		}

		return $flag;
	}

	public function getWinner(): void
	{
		$hero = $_SESSION['hero'];
		$beast = $_SESSION['beast'];
		$_SESSION['game_in_progress'] = FALSE;

		($hero->getData('health') > $beast->getData('health'))
			? $message = "Winner is {$hero->getData('name')}"
			: $message = "Winner is {$beast->getData('name')}";

		$_SESSION['message'] = $message;
	}

	public function reset(): void
	{
		$_SESSION['game_in_progress'] = null;
		$_SESSION['turn'] = null;
		$_SESSION['message'] = null;
		$_SESSION['hero'] = null;
		$_SESSION['beast'] = null;
	}
}