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

class Language {
   public function __construct(
       private readonly LangTypeEnum $langType,
       private readonly array        $messages
   ) {}

    public function getLangType(): LangTypeEnum {
        return $this->langType;
    }

    public function getTranslations(): array {
        return $this->messages;
    }

    /**
     * Exemple: getTranslation("test_translation", ["{user_name}" => $player->getName()])
     * @param string $key
     * @param array $params
     * @return string|null
     */
    public function getTranslation(string $key, array $params): ?string {
        $params["{line}"] = "\n";
        $translation = $this->messages[$key] ?? null;

        if ($translation === null) {
            $translation = "Message not found in language '{$this->getLangType()->getDisplayName()} - {$this->getLangType()->value}': " . $key;
        }

        if (!empty($params) && is_string($translation)) {
            foreach ($params as $param => $value) {
                $translation = str_ireplace($param, (string)$value, $translation);
            }
        }

        return $translation;
    }
}