<?php

namespace Src\Characters;

use Src\Observers\Subject;
use Src\Observers\Observer;

abstract class Character implements Subject
{
	protected $characterData;
	protected $observers = [];

	public function __construct(array $data)
	{
		$this->characterData = $data;
	}

	public function setData(string $key, string $value): void
	{
		$this->characterData[$key] = $value;
	}

	public function getData(string $key)
	{
		if(array_key_exists($key, $this->characterData)){
			return $this->characterData[$key];
		}

		return null;
	}

	public function attack(Character $character): void
	{
		$damage = $this->getData('strength') - $character->getData('defense');
		$character->defend($damage, $this);
	}

	public function defend(int $damage, Character $attacker): void
	{
		$health = $this->getData('health') - $damage;
		$this->setData('health', $health);
	}

	public function attach(Observer $observer): Character
	{
		$this->observers[] = $observer;

		return $this;
	}

	public function detach($observer)
	{
		foreach($this->observers as $okey => $oval) {
			if ($oval == $observer) {
				unset($this->observers[$okey]);
			}
		}
	}

	public function notify(): void
	{
		foreach ($this->observers as $observer) {
			$observer->handle($this);
		}
	}

	public function getStats(): array
	{
		$stats = [];
		$bools = ['isTurn'];
		$exclude = ['hasUsedRapidStrike', 'hasUsedMagicShield'];

		foreach ($this->characterData as $statName => $value) {
			if(in_array($statName, $exclude)){
				continue;
			}

			$stats[$statName] = in_array($statName, $bools) ? $this->getBoolAsString($value) : $value;
		}

		return $stats;
	}

	private function getBoolAsString(bool $value): string
	{
		return $value ? 'true' : 'false';
	}

	public function toggleTurn(): void
	{
		$this->getData('isTurn') ? $this->setData('isTurn', FALSE) : $this->setData('isTurn', TRUE);
	}
}