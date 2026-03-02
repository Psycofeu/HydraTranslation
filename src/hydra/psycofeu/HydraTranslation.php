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

namespace hydra\psycofeu;

use hydra\psycofeu\managers\LangManager;
use hydra\psycofeu\managers\type\LangTypeEnum;
use hydra\psycofeu\players\PlayersManagers;
use pocketmine\utils\SingletonTrait;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use InvalidArgumentException;
use LogicException;
use JsonException;

class HydraTranslation {
    use SingletonTrait;
    private static ?Plugin $registrant = null;

    /**
     * @param Plugin $plugin
     * @param LangTypeEnum $defaultLang
     * @param LangTypeEnum[] $availlabledLangs
     * @throws JsonException
     */
    public function register(Plugin $plugin, LangTypeEnum $defaultLang = LangTypeEnum::EN, array $availlabledLangs = []) : void {
        if(self::isRegistered()) {
            throw new InvalidArgumentException("{$plugin->getName()} attempted to register " . self::class . " twice.");
        }
        self::$registrant = $plugin;

        if (empty($availlabledLangs)) {
            $availlabledLangs = LangTypeEnum::getAll();
        }

        $langManager = self::getLangManager();
        $langManager->setDefaultLang($defaultLang);
        $langManager->loadAllLangs($plugin, $availlabledLangs);
        Server::getInstance()->getPluginManager()->registerEvents(new EventListeners(), $plugin);
    }

    public static function isRegistered() : bool{
        return self::$registrant instanceof Plugin;
    }

    public static function getPlugin() : Plugin{
        return self::$registrant ?? throw new LogicException("Cannot obtain registrant before registration");
    }

    public static function getLangManager() : LangManager {
        return LangManager::getInstance();
    }

    public static function getPlayerManager() : PlayersManagers {
        return PlayersManagers::getInstance();
    }
}