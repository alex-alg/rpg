<?php

namespace Src\Observers\MessageObservers;

use Src\Observers\Observer;
use Src\Characters\Character;

class SkillObserver implements Observer
{
	public function handle(Character $character)
	{
		if($character->getData('hasUsedRapidStrike')){
			$_SESSION['message'] .= '<p>' . $character->getData('name') . ' used Rapid Strike.</p>';
		}

		if($character->getData('hasUsedMagicShield')){
			$_SESSION['message'] .= '<p>' . $character->getData('name') . ' used Magic Shield.</p>';
		}
	}
}