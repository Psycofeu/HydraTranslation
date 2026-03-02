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

namespace hydra\psycofeu\managers\type;

use hydra\psycofeu\HydraTranslation;

enum LangTypeEnum: string {

    case ID = 'id';
    case DA = 'da';
    case DE = 'de';
    case EN = 'en';
    case ES = 'es';
    case FR = 'fr';
    case IT = 'it';
    case HU = 'hu';
    case NL = 'nl';
    case NB = 'nb';
    case PL = 'pl';
    case PT = 'pt';
    case SK = 'sk';
    case FI = 'fi';
    case SV = 'sv';
    case TR = 'tr';
    case CS = 'cs';
    case EL = 'el';
    case BG = 'bg';
    case RU = 'ru';
    case UK = 'uk';
    case JA = 'ja';
    case ZH = 'zh';
    case KO = 'ko';

    public function getDisplayName(): string{
        return match($this){
            self::ID => "Indonesian",
            self::DA => "Danish",
            self::DE => "German",
            self::EN => "English",
            self::ES => "Spanish",
            self::FR => "French",
            self::IT => "Italian",
            self::HU => "Hungarian",
            self::NL => "Dutch",
            self::NB => "Bokmål",
            self::PL => "Polish",
            self::PT => "Portuguese",
            self::SK => "Slovak",
            self::FI => "Finnish",
            self::SV => "Swedish",
            self::TR => "Turkish",
            self::CS => "Czech",
            self::EL => "Greek",
            self::BG => "Bulgarian",
            self::RU => "Russian",
            self::UK => "Ukrainian",
            self::JA => "Japanese",
            self::ZH => "Chinese",
            self::KO => "Korean",
        };
    }

    public static function fromMinecraftLocale(string $locale): self{
        $base = strtolower(explode('_', $locale)[0]);
        return self::tryFrom($base) ?? HydraTranslation::getLangManager()->defaultLang;
    }

    public static function getAll(): array{
        return self::cases();
    }
}