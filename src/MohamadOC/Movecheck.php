<?php 

namespace MohamadOC;

use pocketmine\scheduler\Task;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\entity\Entity;
use MohamadOC\FixSprint;

class Movecheck extends Task{

		public function onRun(int $currentTick) {
		foreach(FixSprint::getInstance()->getServer()->getOnlinePlayers() as $player){
		if(isset(FixSprint::$Moving[$player->getName()])){
		$time = FixSprint::$Moving[$player->getName()];
		$calculate = time() - $time;
		if($calculate > 0.9){
		unset(FixSprint::$Moving[$player->getName()]);
	    unset(FixSprint::$sprinting[$player->getName()]);
		}
		}
		}
		}	
}
