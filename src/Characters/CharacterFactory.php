<?php

namespace Src\Characters;

use Src\Characters\Hero;
use Src\Characters\Beast;
use Src\Characters\Character;
use Src\Exceptions\CharacterTypeException;

class CharacterFactory
{
	public function generateCharacter(string $type, string $name): Character
	{
		$character = null;

		switch ($type) {
			case 'hero':
				$stats = $this->makeHeroStats($name);
				$character = new Hero($stats);
				break;
			case 'beast':
				$stats = $this->makeBeastStats($name);
				$character = new Beast($stats);
				break;
			default:
				throw new CharacterTypeException("Character type does not exist");
				break;
		}

		return $character;
	}

	private function makeHeroStats(string $name): array
	{
		return [
			'name'		=> $name,
			'health'	=> rand(70, 100),
			'strength'	=> rand(70, 80),
			'defense'	=> rand(45, 55),
			'speed'		=> rand(40, 50),
			'luck'		=> rand(10, 30) / 100,
			'isTurn'	=> FALSE,
			'hasUsedRapidStrike' => FALSE,
			'hasUsedMagicShield' => FALSE
		];
	}

	private function makeBeastStats(string $name): array
	{
		return [
			'name'		=> $name,
			'health'	=> rand(60, 90),
			'strength'	=> rand(60, 90),
			'defense'	=> rand(40, 60),
			'speed'		=> rand(40, 60),
			'luck'		=> rand(25, 40) / 100,
			'isTurn'	=> FALSE
		];
	}
}
