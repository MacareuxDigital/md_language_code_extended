<?php

namespace Macareux\LanguageCodeExtended;

use Concrete\Core\Config\Repository\Liaison;
use Punic\Language;

class LanguageList
{
    /** @var Liaison */
    protected $config;

    /**
     * @param Liaison $config
     */
    public function __construct(Liaison $config)
    {
        $this->config = $config;
    }

    public function getLanguageList()
    {
        $excludeCountrySpecific = $this->config->get('language.exclude_country_specific', true);
        $excludeScriptSpecific = $this->config->get('language.exclude_script_specific', true);
        return Language::getAll($excludeCountrySpecific, $excludeScriptSpecific);
    }
}