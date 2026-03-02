<?php

/* 
 * $$$$$$$\                                           $$$$$$\                     
 * $$  __$$\                                         $$  __$$\                    
 * $$ |  $$ | $$$$$$$\ $$\   $$\  $$$$$$$\  $$$$$$\  $$ /  \__|$$$$$$\  $$\   $$\ 
 * $$$$$$$  |$$  _____|$$ |  $$ |$$  _____|$$  __$$\ $$$$\    $$  __$$\ $$ |  $$ |
 * $$  ____/ \$$$$\  $$ |  $$ |$$ /      $$ /  $$ |$$  _|   $$$$$$$$ |$$ |  $$ |
 * $$ |       \____$$\ $$ |  $$ |$$ |      $$ |  $$ |$$ |     $$   ____|$$ |  $$ |
 * $$ |      $$$$$$$  |\$$$$$ |\$$$$$\ \$$$$  |$$ |     \$$$$$\ \$$$$  |
 * \__|      \_______/  \____$$ | \_______| \______/ \__|      \_______| \______/ 
 *                     $$\   $$ |                                                 
 *                     \$$$$  |                                                 
 *                      \______/                                                  
 * Ce programme est strictement privé.
 * Toute reproduction, diffusion ou fuite est interdite.
 * Merci de respecter le travail de l’auteur.
 * @author Psycofeu
 * @donation https://paypal.me/Hydramcbe
 * @view https://discord.gg/SaUQUt3gFM 
*/

namespace hydra\psycofeu\players;

use Hydra\libs\HydraTranslation\src\hydra\psycofeu\players\TranslationPlayer;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;

class PlayersManagers {
    use SingletonTrait;

    /** @var TranslationPlayer[] */
    public array $players = [];

    public function getOrCreate(Player|string $player): ?TranslationPlayer {
        $player = $player instanceof Player ? $player : Server::getInstance()->getPlayerExact($player);
        $playerName = strtolower($player?->getName() ?? "underfind");

        if (!isset($this->players[$playerName])) {
            $this->players[$playerName] = new TranslationPlayer($playerName, $player->getLocale());
        }
        return $this->players[$playerName] ?? null;
    }

    public function exist(string $playerName): bool {
        return isset($this->players[strtolower($playerName)]);
    }

    public function remove(string $playerName): void {
        unset($this->players[strtolower($playerName)]);
    }

    public function broadcastTranslatedMessage(string $key, array $params): void {
        array_map(function(TranslationPlayer $player) use ($key, $params) : void {
            $player->sendTranslateMessage($key, $params);
        }, $this->players);
    }
}