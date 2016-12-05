<?php
namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\network\protocol\AddEntityPacket;

class Endermite extends Monster{
    const NETWORK_ID = 55;

    public $height = 0.438;
    public $width = 0.609;
    public $lenght = 1.094;
	
	protected $exp_min = 3;
	protected $exp_max = 3;

    public function initEntity(){
        $this->setMaxHealth(8);
        parent::initEntity();
    }

 	public function getName(){
        return "Endermite";
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
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}
