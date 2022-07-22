<?php 

namespace MohamadOC;

use pocketmine\event\Listener;
use pocketmine\PLayer;
use pocketmine\plugin\PluginBase;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\Server;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\block\Block;
use pocketmine\scheduler\Task;
use pocketmine\event\level\LevelLoadEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\entity\Entity;
use pocketmine\level\sound\{EndermanTeleportSound, ClickSound, GhastShootSound};
use pocketmine\utils\Config;
use MohamadOC\Movecheck;
use pocketmine\event\player\PlayerMoveEvent;
use MohamadOC\JoinNEWS;
use pocketmine\event\player\PlayerToggleSprintEvent;

/*
Author : MohamadOC

Discord : https://discord.gg/U9SySWNzHp

PMMP [3.0.0]

This plugin was made to fix the sprint Problem

for version 1.19.XX.

its legal to edit this Plugin.

*/
class FixSprint extends PluginBase implements Listener{
    /*
    to make it easier to get the main
    with our to make a construct in every file 
    */
	private static $instance;
    
	public static $sprinting = [];
	/*
    array of Players that starts sprinting
	*/
	public static $Moving = [];
	/*
    array of Players that start Moving and in the
    task Movecheck we check if they stopped moving.
	*/

	public function onEnable(): void{
	/*
    register events
	*/
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getServer()->getPluginManager()->registerEvents(new JoinNEWS(), $this);
    $this->getResource("News.yml");
    $this->saveResource("News.yml");
    /*
    task to check if the player is moving!, if not then stop the sprint.
    */
    $this->getScheduler()->scheduleRepeatingTask(new Movecheck(), 1);
    self::$instance = $this;

	}
    /*
    News...Sprint got fixed.....
    */
	public function onjoin(PlayerJoinEvent $e): void{
    $p = $e->getPlayer();
    $config = new Config($this->getDataFolder()."News.yml", Config::YAML);
    $class = new JoinNEWS();
    if($config->get("status") == true){
    $class->NEWSUI($p);
    } else {
    if($p->isOp()){
    $p->sendMessage("§lThis message was only sent to you because you are Op !\n§lto turn the News UI Message on go to the config of this plugin[FixSprint 1.19.XX] Config : (News.yml)");
    return;
    }	
    }
	}

	/*
    to unset the the moving array / sprinting array onQuiting
	*/
	public function onQuit(PlayerQuitEvent $e){
	$p = $e->getPlayer();
	unset(self::$Moving[$p->getName()]);
	unset(self::$sprinting[$p->getName()]);
	}

	public static function getInstance(): FixSprint{
		return self::$instance;
	}

	public function onSprinting(PlayerToggleSprintEvent $e){
	$p = $e->getPlayer();
    self::$sprinting[$p->getName()] = 0;
	}

	public function onMove(PlayerMoveEvent $e){
	$p = $e->getPlayer();
	self::$Moving[$p->getName()] = time();
	if(isset(self::$Moving[$p->getName()]) && isset(self::$sprinting[$p->getName()]) && !$p->isSneaking()){
	$p->setSprinting();
	}
	}
}
