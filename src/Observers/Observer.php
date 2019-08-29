<?php

namespace Src\Observers;

use Src\Characters\Character;

interface Observer{
	public function handle(Character $character);
}