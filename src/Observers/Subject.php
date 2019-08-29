<?php

namespace Src\Observers;

interface Subject
{
	public function attach(Observer $observer);
	public function detach($observer);
	public function notify();
}