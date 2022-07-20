<?php 


namespace MohamadOC;

use pocketmine\Player;
use pocketmine\event\Listener;
use MohamadOC\FixSprint;
use pocketmine\utils\Config;

class JoinNEWS implements Listener{

	public function NEWSUI(Player $p){
    $api = FixSprint::getInstance()->getServer()->getPluginManager()->getPlugin("FormAPI");
    $form = $api->createSimpleForm(function (Player $p, int $data = null){
    $result = $data;
    if($result === null){
    return true;
    }             
    switch($result){
    case 0:
    break;
    }
    });
    $form->setTitle("§l§4News§f!");
    $config = new Config(FixSprint::getInstance()->getDataFolder()."News.yml", Config::YAML);
    $form->setContent($config->get("news"));
    $form->addButton("§l§fNice", 0, "textures/ui/check.png");
    $form->sendToPlayer($p);
    return $form;

	}
}