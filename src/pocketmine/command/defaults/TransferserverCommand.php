<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\network\protocol\TransferPacket;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class TransferserverCommand extends VanillaCommand {

	public function __construct($name) {
		parent::__construct(
			$name,
			"Connect to another server",
			"transferserver address:string port:short",
			["ts"]
		);
		$this->setPermission("pocketmine.command.transferserver");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args) {
		if (!$this->testPermission($sender)) {
			return true;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . 'A console can not be transferred!');
			return true;
		}

		/** @var string $address
		 * @var $port
		 */
		if (count($args) < 2 || !is_string(($address = $args[0])) || !is_int(($port = $args[1]))) {
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return false;
		}

		$pk = new TransferPacket();
		$pk->port = (int)$port;
		$pk->address = $address;
		/** @var Player $sender */
		$sender->dataPacket($pk);
		$sender->getServer()->getLogger()->info('Transferring player "' . $sender->getName() . '" to ' . $address . ':' . $port);

		return true;
	}
}