<?php

namespace Src\Observers\MessageObservers;

use Src\Observers\Observer;
use Src\Characters\Character;

class DamageObserver implements Observer
{
	const TYPE_HERO = 'hero';
	const TYPE_BEAST = 'beast';

	public function handle(Character $character)
	{
		if($character->getData('isTurn')){
			$attackerCharacterType = $this->getCharacterType($character);
			$defendingCharacterType = $attackerCharacterType === self::TYPE_HERO ? self::TYPE_BEAST : self::TYPE_HERO;

			$damage = $character->getData('strength') - $_SESSION[$defendingCharacterType]->getData('defense');
			$damage = $character->getData('hasUsedRapidStrike') ? $damage * 2 : $damage;

			$_SESSION['message'] .= '<p>' .
									$character->getData('name') .
									' attacked with ' . $damage .
									' damage.</p>';
		}

		if(!$character->getData('isTurn')){
			$defendingCharacterType = $this->getCharacterType($character);
			$attackerCharacterType = $defendingCharacterType === self::TYPE_HERO ? self::TYPE_BEAST : self::TYPE_HERO;

			$damage = $_SESSION[$attackerCharacterType]->getData('strength') - $character->getData('defense');
			$damage = $_SESSION[$attackerCharacterType]->getData('hasUsedRapidStrike') ? $damage * 2 : $damage;
			$damage = $character->getData('hasUsedMagicShield') ? $damage / 2 : $damage;

			$_SESSION['message'] .= '<p>' . $character->getData('name') . ' took ' . $damage . ' damage.</p>';
		}
	}

	private function getCharacterType(Character $character): string
	{
		$classParts = explode("\\", get_class($character));

		return strtolower(end($classParts));
	}
}