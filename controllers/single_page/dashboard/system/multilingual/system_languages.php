<?php

namespace Concrete\Package\MdLanguageCodeExtended\Controller\SinglePage\Dashboard\System\Multilingual;

use Concrete\Core\Package\PackageService;
use Concrete\Core\Page\Controller\DashboardPageController;

class SystemLanguages extends DashboardPageController
{
    public function view()
    {
        $this->set('exclude_country_specific', $this->getPackageConfig()->get('language.exclude_country_specific', true));
        $this->set('exclude_script_specific', $this->getPackageConfig()->get('language.exclude_script_specific', true));
    }

    protected function getPackageConfig()
    {
        /** @var PackageService $packageService */
        $packageService = $this->app->make(PackageService::class);
        $package = $packageService->getClass('md_language_code_extended');
        return $package->getFileConfig();
    }

    public function submit()
    {
        if (!$this->token->validate('update_system_languages')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has()) {

            $config = $this->getPackageConfig();
            $config->save('language', [
                'exclude_country_specific' => (bool) $this->post('exclude_country_specific'),
                'exclude_script_specific' => (bool) $this->post('exclude_script_specific'),
            ]);

            $this->flash('success', t('The settings has been successfully updated.'));

            return $this->buildRedirect([$this->getPageObject()]);
        }
    }
}
