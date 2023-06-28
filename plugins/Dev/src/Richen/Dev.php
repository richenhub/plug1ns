<?php 

namespace Richen;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\event\player\PlayerInteractEvent;

class Dev extends PluginBase implements Listener {
    public $enabled = [];
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onClick(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        if (!isset($this->enabled[$player->getName()])) {
            return;
        }
        $item = $event->getItem();
        $itemName = $item->getName();
        $itemId = $item->getId();
        $itemDamage = $item->getDamage();
        $itemCount = $item->getCount();
        $block = $event->getBlock();
        $blockName = $block->getName();
        $blockId = $block->getId();
        $blockDamage = $block->getDamage();
        $x = $block->getX();
        $y = $block->getY();
        $z = $block->getZ();
        $player->sendMessage("Вы тапнули предметом: $itemName ($itemId:$itemDamage - $itemCount шт.)");
        $player->sendMessage("Вы тапнули по блоку: $blockName ($blockId:$blockDamage - x: $x, y: $y, z: $z");
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        if ($command->getName() == "dev") {
            if (isset($this->enabled[$sender->getName()])) {
                unset($this->enabled[$sender->getName()]);
                $sender->sendMessage("§eВы §cвыключили §eкоманду разработчика");
            } else {
                $this->enabled[$sender->getName()] = true;
                $sender->sendMessage("§eВы §aвключили §eкоманду разработчика");
            }
        }
        return false;
    }
}