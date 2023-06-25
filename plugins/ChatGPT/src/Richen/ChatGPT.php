<?php 

namespace Richen;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;

use pocketmine\event\player\PlayerChatEvent;

class ChatGPT extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onChat(PlayerChatEvent $event) {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $first = $message[0];
        if ($first == '@') {
            $event->setCancelled(true);
            $message = mb_substr($message, 1);
            $result = $this->chatGPT($message);
            $result = preg_replace('/\s{2,}/', ' ', $result);
            if ($result != null) {
                $this->getServer()->broadcastMessage('§8[§eChatGPT§8] §fИгрок §b' . $player->getName() . ' §fнаписал нейросети: §7' . $message);
                $this->getServer()->broadcastMessage('§8[§eChatGPT§8] §7Нейросеть пишет: §f' . $result);
            }
        }
    }

    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        $commandName = $command->getName();
        if ($commandName == "chatgpt" && count($args)) {
            $message = implode(' ', $args);
            $result = $this->chatGPT($message);
            $result = preg_replace('/\s{2,}/', ' ', $result);
            if ($result != null) {
                $this->getServer()->broadcastMessage('§8[§eChatGPT§8] §fИгрок §b' . $sender->getName() . ' §fнаписал нейросети: §7' . $message);
                $this->getServer()->broadcastMessage('§8[§eChatGPT§8] §7Нейросеть пишет: §f' . $result);
            }
        } else {
            $sender->sendMessage('§8[§eChatGPT§8] §6Используйте: §f/chatgpt <сообщение/вопрос>');
        }
        return true;
    }

    public function chatGPT(string $message) {
        $apiKey = 'ВАШ ТОКЕН';
        $url = 'https://api.openai.com/v1/engines/text-davinci-003/completions';
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $apiKey);
        $data = array('prompt' => $message, 'max_tokens' => 250, 'temperature' => 0.7);
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $responseData = json_decode($response, true);
        if (isset($responseData['choices'][0]['text'])) {
            return $responseData['choices'][0]['text'];
        }
        return null;
    }
}