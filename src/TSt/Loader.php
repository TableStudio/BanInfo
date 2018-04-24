<?php
namespace TSt;

use TSt\commands\BanInfo;
use TSt\commands\BanInfoIP;

use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Enum;
use pocketmine\network\protocol\MobEffectPacket;
use pocketmine\network\protocol\SetTimePacket;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\Random;
use pocketmine\utils\TextFormat;


class Loader extends PluginBase{
  public function onLoad(){
    $this->registerCommands();
    $this->getServer()->getLogger()->info("§2[BanInfo]§a Загрузка....");
  }
  
  private function unregisterCommands(array $commands){
        $commandmap = $this->getServer()->getCommandMap();
        foreach($commands as $commandlabel){
            $command = $commandmap->getCommand($commandlabel);
            $command->setLabel($commandlabel . "_disabled");
            $command->unregister($commandmap);
        }
    }
    private function registerCommands(){
        $this->unregisterCommands([

        ]);
        $this->getServer()->getCommandMap()->registerAll("BanInfo", [
            new BanInfo($this),
            new BanInfoIP($this)
		]);
	}
}