<?php

declare(strict_types=1);

namespace NoobMCBG\BlackMarket\commands;

use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use NoobMCBG\BlackMarket\Forms;
use NoobMCBG\BlackMarket\BlackMarket;
use jojoe77777\FormAPI\SimpleForm;

class BlackMarketCommands extends Command implements PluginOwned {

	private BlackMarket $plugin;

	public function __construct(BlackMarket $plugin){
		$this->plugin = $plugin;
		parent::__construct("blackmarket", "Lệnh Để Mở Menu Chợ Đen", null, ["choden"]);
	}

	public function execute(CommandSender $sender, string $label, array $args){
        	if($sender instanceof Player){
        		$this->menuMarkets($sender);
        	}else{
        		$this->plugin->getLogger()->error("Please use command in-game");
        	}
	}
	
	private function menuMarkets(Player $player){
		$form = new SimpleForm(function(Player $player, $data) {
			if($data == null){
				return true;
			}
			if($data == 0){
				return true;
			}
			if($this->getOwningPlugin()->getMarket()->exists($data)){
				if(!$player->hasPermission($this->getOwningPlugin()->getMarket()->get($data)["permission"])){
					if($coin = \onebone\coinapi\CoinAPI::getInstance()->myCoin($player) >= $cost = $this->getOwningPlugin()->getMarket()->get($data)["cost"]){
			    		$this->getOwningPlugin()->getServer()->getCommandMap()->dispatch(new \pocketmine\console\ConsoleCommandSender($this->getOwningPlugin()->getServer(), $instance->getServer()->getLanguage()), "setuperm ".$player->getName()." ".$instance->getMarket()->get($data)["permission"]);
			    		$feature = str_replace(["", "", "", "", ""], ["§l", "§c", "§e", "•", " "], $this->getOwningPlugin()->getMarket()->get($data)["name"]);
			    		$player->sendMessage("§l§c•§e Bạn Đã Mua Thành Công Tính Năng§a $feature");
			    	}
			    }else{
			    	$player->sendMessage("§l§c•§e Bạn Đã Mua Tính Năng Này Trước Đó Rồi !");
			    }
			}
		});
        	$form->setTitle("§l§6♦§2 Chợ Đen §6♦");
        	$form->addButton("§l§3•§2 Thoát Menu §3•");
        	for($i = 1;$i <= 30;$i++){
        		if($this->getOwningPlugin()->getMarket()->exists($i)){
        	    		$form->addButton($this->getOwningPlugin()->getMarket()->get($i)["button"], 1, $this->getOwningPlugin()->getMarket()->get($i)["icon"]);
        		}
        	}
        	$player->sendForm($form);
	}

	public function getOwningPlugin() : BlackMarket {
		return $this->plugin;
	}
}
