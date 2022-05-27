<?php

declare(strict_types=1);

namespace NoobMCBG\BlackMarket\commands;

use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use NoobMCBG\BlackMarket\Forms;
use NoobMCBG\BlackMarket\BlackMarket;

class BlackMarketCommands extends Command implements PluginOwned {

	private BlackMarket $plugin;

	public function __construct(BlackMarket $plugin){
		$this->plugin = $plugin;
		parent::__construct("blackmarket", "Lệnh Để Mở Menu Chợ Đen", null, ["choden"]);
	}

	public function execute(CommandSender $sender, string $label, array $args){
        	if($sender instanceof Player){
        		Forms::menuMarkets($sender);
        	}else{
        		$this->plugin->getLogger()->error("Please use command in-game");
        	}
	}

	public function getOwningPlugin() : BlackMarket {
		return $this->plugin;
	}
}
