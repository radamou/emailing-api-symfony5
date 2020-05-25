<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Entity;

class TemplateLanguage
{
    public const EN_LANG = 'en';
    public const  FR_LANG = 'fr';
    public const LANGUAGES = [self::EN_LANG, self::FR_LANG];
    public const CHOICES = [
        'French' => self::FR_LANG,
        'English' => self::EN_LANG,
    ];
}
