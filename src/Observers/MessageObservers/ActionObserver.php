<?php

namespace Src\Observers\MessageObservers;

use Src\Observers\Observer;
use Src\Characters\Character;

class ActionObserver implements Observer
{
	public function handle(Character $character)
	{
		if($character->getData('isTurn')){
			$_SESSION['message'] .= '<p>' . $character->getData('name') . ' attacked. </p>';
		}

		if(!$character->getData('isTurn')){
			$_SESSION['message'] .= '<p>' . $character->getData('name') . ' defended.</p>';
		}
	}
}