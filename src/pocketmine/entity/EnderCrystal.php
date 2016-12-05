<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\level\format\Chunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;
use pocketmine\network\protocol\AddEntityPacket;

class EnderCrystal extends Entity implements Explosive{
	const NETWORK_ID = 62;

	public $height = 1;
	public $width = 1;
	public $lenght = 1;//TODO: Size
	
	public function __construct(Chunk $chunk, CompoundTag $nbt){
		parent::__construct($chunk, $nbt);
	}

	public function initEntity(){
		$this->setMaxHealth(1);
		parent::initEntity();
	}

	public function getName(){
		return "Ender Crystal";
	}

	public function kill(){
		if(!$this->isAlive()){
			return;
		}
		$this->explode();
		parent::kill();
		if(!$this->closed){
			$this->close();
		}
	}

	public function explode(){
		$this->server->getPluginManager()->callEvent($ev = new ExplosionPrimeEvent($this, 6));

		if(!$ev->isCancelled()){
			$explosion = new Explosion($this, $ev->getForce(), $this);
			if($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->type = self::NETWORK_ID;
		$pk->eid = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}
