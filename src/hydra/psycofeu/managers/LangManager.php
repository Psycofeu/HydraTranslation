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

namespace hydra\psycofeu\managers;

use hydra\psycofeu\managers\type\LangTypeEnum;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use JsonException;
use pocketmine\utils\SingletonTrait;

class LangManager {
    use SingletonTrait;

    /** @var Language[]  */
    public array $langs;

    public LangTypeEnum $defaultLang = LangTypeEnum::EN;

    public function setDefaultLang(LangTypeEnum $defaultLang): void {
        $this->defaultLang = $defaultLang;
    }

    /** @param LangTypeEnum[] $availlabledLangs
     * @throws JsonException
     */
    public function loadAllLangs(Plugin $instance, array $availlabledLangs): void {
        $langs = [];
        $dataFolder = $instance->getDataFolder();
        $langFolder = $dataFolder . "langs/";

        if (!is_dir($langFolder)) {
            @mkdir($langFolder, 0777, true);
        }

        foreach ($availlabledLangs as $langCode) {
            $file = $langFolder . $langCode->value . ".ini";

            if (!file_exists($file)) {
                $defaultData = ["discord" => "§9- §fOur discord is §9{link}"];
                $config = new Config($file, Config::YAML, $defaultData);
                $config->save();
            } else {
                $config = new Config($file, Config::YAML);
            }

            $langs[$langCode->value] = new Language($langCode ,$config->getAll());
        }
        $this->langs = $langs;
    }

    public function getPlayerLang(?CommandSender $sender): string {
        return $sender instanceof Player ? $sender->getLocale() : $this->defaultLang->value;
    }

    public function getLanguageFromLanguageCode(string $langCode): Language {
        return $this->langs[strtolower($langCode)] ?? $this->langs[strtolower($this->defaultLang->value)];
    }
}