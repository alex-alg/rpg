<?php
namespace Src\Characters;

use Src\Characters\Character;

class Hero extends Character
{
	const RAPDI_STRIKE_PROB = 10;
	const MAGIC_SHILD_PROB = 20;

	public function __construct(array $data)
	{
		parent::__construct($data);
	}

	public function attack(Character $character): void
	{
		$damage = $this->getData('strength') - $character->getData('defense');

		if($this->useRapidStrike()){
			$this->setData('hasUsedRapidStrike', true);
			$damage = $damage * 2;
		}

		$character->defend($damage, $this);
	}

	public function defend(int $damage, Character $attacker): void
	{
		if($this->useMagicShield()){
			$this->setData('hasUsedMagicShield', true);
			$damage = $damage / 2;
		}

		parent::defend($damage, $attacker);
	}

	public function useRapidStrike(): bool
	{
		return rand(1, 100) <= self::RAPDI_STRIKE_PROB;
	}

	public function useMagicShield(): bool
	{
		return rand(1, 100) <= self::MAGIC_SHILD_PROB;
	}

	public function resetSpecialSkills(): void
	{
		$this->setData('hasUsedRapidStrike', FALSE);
		$this->setData('hasUsedMagicShield', FALSE);
	}
}