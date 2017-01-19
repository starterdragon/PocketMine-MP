<?php
namespace pocketmine\tile;

use pocketmine\level\format\Chunk;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;

class Beacon extends Spawnable{
    public $primary = 0, $secondary = 0;

	public function __construct(Chunk $chunk, CompoundTag $nbt){
        $this->primary = (int) $this->namedtag["primary"];
        $this->secondary = (int) $this->namedtag["secondary"];
		parent::__construct($chunk, $nbt);
	}

	public function saveNBT(){
		parent::saveNBT();
	}

	public function getName(){
		return "Beacon";
	}

	public function getSpawnCompound(){
		return new CompoundTag("", [
			new StringTag("id", Tile::BEACON),
            new ByteTag("isMovable", (bool) true),
            new IntTag("primary", (int) $this->primary),
            new IntTag("secondary", (int) $this->secondary),
            new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z)
		]);
	}
}