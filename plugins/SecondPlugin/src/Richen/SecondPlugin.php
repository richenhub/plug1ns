<?php 

namespace Richen;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\Player;

class SecondPlugin extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        $cmdName = $command->getName();
        if ($cmdName == "fly") {
            if (isset($args[0])) {
                $nick = $args[0];
                $player = $this->getServer()->getPlayerExact($nick);
                if ($player != null) {
                    if ($player->getAllowFlight() == true) {
                        $value = false;
                        $text = "§cвыключен";
                    } else {
                        $value = true;
                        $text = "§aвключен";
                    }
                    $player->setAllowFlight($value);
                    $sender->sendMessage("§eРежим полёта для игрока §f$nick §eбыл $text");
                    $player->sendMessage("§eВаш режим полёта был $text");
                } else {
                    $sender->sendMessage("§cИгрок с ником §6$nick §cне онлайн");
                }
            } else {
                if ($sender instanceof Player) {
                    if ($sender->getAllowFlight() == true) {
                        $value = false;
                        $text = "§cвыключен";
                    } else {
                        $value = true;
                        $text = "§aвключен";
                    }
                    $sender->setAllowFlight($value);
                    $sender->sendMessage("§eВаш режим полёта был $text");
                } else {
                    $sender->sendMessage("Команду можно ввести только в игре");
                }
            }
        }
        return false;
    }
}