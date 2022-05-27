<?php

declare(strict_types=1);

namespace NoobMCBG\BlackMarket;

use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use NoobMCBG\BlackMarket\commands\BlackMarketCommands;

class BlackMarket extends PluginBase implements Listener {

	public static $instance;

	public static function getInstance() : self {
		return self::$instance;
	}

	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveResource("market.yml");
		$this->market = new Config($this->getDataFolder() . "market.yml", Config::YAML);
		$this->getServer()->getCommandMap()->register("/market", new BlackMarketCommands($this));
		self::$instance = $this;
	}

	public function getMarket(){
		return $this->market;
	}

	public function onDisable() : void {
		$this->market->save();
	}
}