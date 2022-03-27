<?php

namespace Concrete\Package\MdLanguageCodeExtended\Controller\SinglePage\Dashboard\System\Multilingual;

use Concrete\Core\Localization\Service\CountryList;
use Concrete\Core\Package\PackageService;
use Concrete\Core\Page\Controller\DashboardPageController;

class SystemCountries extends DashboardPageController
{
    public function view()
    {
        $this->set('country_codes', $this->getPackageConfig()->get('country.additional_codes', []));
    }

    protected function getPackageConfig()
    {
        /** @var PackageService $packageService */
        $packageService = $this->app->make(PackageService::class);
        $package = $packageService->getClass('md_language_code_extended');
        return $package->getFileConfig();
    }

    public function add()
    {
        if (!$this->token->validate('add_system_countries')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $tag = $this->post('tag');
        $label = $this->post('label');

        if (empty($tag)) {
            $this->error->add(t('Please input country code.'));
        }

        if (empty($label)) {
            $this->error->add(t('Please input country label.'));
        }

        /** @var CountryList $country_list */
        $country_list = $this->app->make('localization/countries');
        $countries = $country_list->getCountries();
        if (array_key_exists($tag, $countries)) {
            $this->error->add(t('%s is already registered.', $tag));
        }

        if (!$this->error->has()) {
            $config = $this->getPackageConfig();
            $country_codes = $config->get('country.additional_codes', []);
            $country_codes[$tag] = $label;
            $config->save('country.additional_codes', $country_codes);

            $this->flash('success', t('An additional country code has been successfully updated.'));

            return $this->buildRedirect([$this->getPageObject()]);
        }
    }

    public function delete($code, $token)
    {
        if (!$this->token->validate('delete_system_country', $token)) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has()) {
            $config = $this->getPackageConfig();
            $country_codes = $config->get('country.additional_codes', []);
            unset($country_codes[$code]);
            $config->save('country.additional_codes', $country_codes);

            $this->flash('success', t('An additional country code has been successfully updated.'));

            return $this->buildRedirect([$this->getPageObject()]);
        }
    }
}
