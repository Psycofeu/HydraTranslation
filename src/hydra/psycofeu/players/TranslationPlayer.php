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

use hydra\psycofeu\HydraTranslation;
use hydra\psycofeu\managers\Language;
use pocketmine\player\Player;
use pocketmine\Server;

class TranslationPlayer {
    public Player $player;

    public function __construct(
        public string $name,
        public string $lang,
    ) {
        $this->player = Server::getInstance()->getPlayerExact($this->name);
    }

    public function getLanguage(): Language {
        return HydraTranslation::getLangManager()->getLanguageFromLanguageCode(strtoupper(substr($this->lang, 0, 2)));
    }

    public function translateMessage(string $key, array $params) : string {
        return $this->getLanguage()->getTranslation($key, $params);
    }

    public function sendTranslateMessage(string $key, array $params) : void {
        $this->player->sendMessage(self::translateMessage($key, $params));
    }
}