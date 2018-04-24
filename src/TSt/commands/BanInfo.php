<?php
namespace TSt\commands;
use TSt\Loader;
use TSt\APIs\API;
use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\command\Command;

class BanInfo extends API{
	public function __construct(Loader $plugin){
        parent::__construct($plugin, "baninfo", "Информация о бане", "/bi <ник>", null, ["bi", "tbi"]);
        $this->setPermission("baninfo.commands.baninfo");
    }

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
        
		if(count($args) === 0){
            $sender->sendMessage("/bi <ник>");

			return false;
		}
    $value = array_shift($args);
    
    $bans = file_get_contents("banned-players.txt", $sender->getServer()->getDataPath());
    $bans = str_replace(" victim name | ban date | banned by | banned until | reason\n", '', $bans);
    $bans = explode("#", $bans);
    $bans = $bans[2];
    $baninfo = explode("\n", $bans);
    $count = count($baninfo);
    $i = 0;
    $arr = [
    '',
  'января',
  'февраля',
  'марта',
  'апреля',
  'мая',
  'июня',
  'июля',
  'августа',
  'сентября',
  'октября',
  'ноября',
  'декабря'
];
        for($k = 0; $k<$count; $k++){
            $baninfoP = explode("|", $baninfo[$k]);
            if($baninfoP[0] != $value){
                
            }else{
                $i++;
                $nick = $baninfoP[0];
                $by = $baninfoP[2];
                $date1 = str_replace(date("O"), "", $baninfoP[1]);
                $date = date('j '.$arr[date('n', strtotime($date1))].' Y H:i:s', strtotime($date1));
                if($baninfoP[3] != 'Forever'){ 
                    $date1 = str_replace(date("O"), "", $baninfoP[3]);
                    $until = date('j '.$arr[date('n', strtotime($date1))].' Y H:i:s', strtotime($date1));
                }else{
                    $until = 'Бан навсегда';
                }$reason = $baninfoP[4];
            }
            
        }
        if($i == 0){
            $sender->sendMessage('§4[BanInfo] §cОшибка: Такого игрока нет в бан-листе!');
        }else{
            $sender->sendMessage("§6--=== §c".$nick."§6 ===--\n§6Забанен:§c ".$date."\n§6Забанил: §c".$by."\n§6Бан оканчивается: §c".$until."\n§6Причина бана: §c".$reason);
        }
    }
}
