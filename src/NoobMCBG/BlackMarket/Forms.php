<?php

declare(strict_types=1);

namespace NoobMCBG\BlackMarket;

use pocketmine\player\Player;
use jojoe77777\FormAPI\SimpleForm;
use NoobMCBG\BlackMarket\BlackMarket;

class Forms {

	public static function menuMarkets(Player $player){
		$instance = BlackMarket::getInstance();
		$form = new SimpleForm(function(Player $player, $data) use ($instance) {
			if($data == null){
				return true;
			}
			if($data == 0){
				return true;
			}
			if($instance->getMarket()->exists($data)){
				if(!$player->hasPermission($instance->getMarket()->get($data)["permission"])){
					if($coin = \onebone\coinapi\CoinAPI::getInstance()->myCoin($player) >= $cost = $instance->getMarket()->get($data)["cost"]){
			    		$instance->getServer()->getCommandMap()->dispatch(new \pocketmine\console\ConsoleCommandSender($instance->getServer(), $instance->getServer()->getLanguage()), "setuperm ".$player->getName()." ".$instance->getMarket()->get($data)["permission"]);
			    		$feature = str_replace(["", "", "", "", ""], ["§l", "§c", "§e", "•", " "], $instance->getMarket()->get($data)["name"]);
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
        		if($instance->getMarket()->exists($i)){
        	    		$form->addButton($instance->getMarket()->get($i)["button"], 1, $instance->getMarket()->get($i)["icon"]);
        		}
        	}
        	$form->sendToPlayer($player);
	}
}
