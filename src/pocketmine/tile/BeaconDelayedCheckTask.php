<?php

namespace pocketmine\tile;


use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class BeaconDelayedCheckTask extends Task {
	/**
	 * @var Vector3 $pos
	 */
	private $pos;
	/**
	 * @var int $levelId
	 */
	private $levelId;

	public function __construct(Vector3 $pos, $levelId) {
		$this->pos = $pos;
		$this->levelId = $levelId;
	}

	/**
	 * Actions to execute when run
	 *
	 * @param $currentTick
	 *
	 * @return void
	 */
	public function onRun($currentTick) {
		$level = Server::getInstance()->getLevel($this->levelId);
		if (!Server::getInstance()->isLevelLoaded($level->getName()) || !$level->isChunkLoaded($this->pos->x >> 4, $this->pos->z >> 4)) return;
		//Stop server from ticking it when chunk unloaded
		$tile = $level->getTile($this->pos);
		if ($tile instanceof Beacon) {
			$tile->scheduleUpdate();
		}
	}
}