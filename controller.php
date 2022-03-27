<?php

namespace Concrete\Package\MdLanguageCodeExtended;

use Concrete\Core\Application\Application;
use Concrete\Core\Package\Package;
use Macareux\LanguageCodeExtended\LanguageList;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class Controller extends Package
{
    /**
     * The minimum concrete5 version compatible with this package.
     *
     * @var string
     */
    protected $appVersionRequired = '8.5.0';

    /**
     * The handle of this package.
     *
     * @var string
     */
    protected $pkgHandle = 'md_language_code_extended';

    /**
     * The version number of this package.
     *
     * @var string
     */
    protected $pkgVersion = '0.0.1';

    /**
     * @see https://documentation.concretecms.org/developers/packages/adding-custom-code-to-packages
     *
     * @var string[]
     */
    protected $pkgAutoloaderRegistries = [
        'src' => '\Macareux\LanguageCodeExtended',
    ];

    /**
     * Get the translated name of the package.
     *
     * @return string
     */
    public function getPackageName()
    {
        return t('Macareux Language Code Extended');
    }

    /**
     * Get the translated package description.
     *
     * @return string
     */
    public function getPackageDescription()
    {
        return t('Make it enable to add special language codes.');
    }

    /**
     * Install this package.
     *
     * @see https://documentation.concretecms.org/developers/packages/installation/overview
     *
     * @return \Concrete\Core\Entity\Package
     */
    public function install()
    {
        $package = parent::install();

        $this->installContentFile('install/singlepages.xml');

        return $package;
    }

    public function on_start()
    {
        $config = $this->getFileConfig();
        $this->app->singleton('localization/languages', function ($app) use ($config) {
            /** @var Application $app */
            return $app->make(LanguageList::class, ['config' => $config]);
        });
        $countries = $config->get('country.additional_codes', []);
        if (count($countries) > 0) {
            /** @var EventDispatcherInterface $dispatcher */
            $dispatcher = $this->app->make(EventDispatcherInterface::class);
            $dispatcher->addListener('on_get_countries_list', function ($event) use ($countries) {
                /** @var GenericEvent $event */
                $coreCountries = $event->getArgument('countries');
                $merged = array_merge($coreCountries, $countries);
                $event->setArgument('countries', $merged);
            });
        }
    }
}