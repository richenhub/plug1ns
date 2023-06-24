<?php 

namespace Richen;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;

class FirstPlugin extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getLogger()->info("§aНаш плагин запустился");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDisable() {
        $this->getServer()->getLogger()->info("§cНаш плагин выключился");
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        $commandName = $command->getName();
        $nickName = $sender->getName();
        if ($commandName == "cmd1") {
            $sender->sendMessage("§eТы ввёл комманду §a1");
        }
        if ($commandName == "cmd2") {
            $sender->sendMessage("§eТы ввёл комманду §a2! Твой ник: $nickName");
        }
        return false;
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $nickName = $player->getName();
        $event->setJoinMessage("§aИгрок §b$nickName §aзашел на сервер! §6Поприветствуем!");
        $player->sendMessage("§eТы зашел на сервак, чувак! §b$nickName");
    }

    public function onMove(PlayerMoveEvent $event) {
        $player = $event->getPlayer();
        $nickName = $player->getName();
        $x = $player->getFloorX();
        $y = $player->getFloorY();
        $z = $player->getFloorZ();
        $player->sendTip("$nickName: x: $x, y: $y, z: $z");
    }
}