<?php

namespace Backend\Modules\Orders\Installer;

use Backend\Core\Installer\ModuleInstaller;
use Backend\Core\Engine\Model as BackendModel;

/**
 * Class Installer
 * @package Backend\Modules\Order\Installer
 */
class Installer extends ModuleInstaller
{

    /**
     *
     */
    public function install()
    {
        $this->importSQL(dirname(__FILE__).'/Data/install.sql');

        $this->addModule('Orders');

        $this->importLocale(dirname(__FILE__).'/Data/locale.xml');

        $this->setModuleRights(1, 'Orders');
        $this->setActionRights(1, 'Orders', 'Edit');
        $this->setActionRights(1, 'Orders', 'Index');

        $this->insertExtra('Orders', 'block', 'Orders', null, null, 'N', 70000);

        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $navigationMembersId = $this->setNavigation($navigationModulesId, 'Orders');
        $this->setNavigation(
            $navigationMembersId,
            'Overview',
            'orders/index',
            array(
                'orders/edit',
            )
        );

        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation($navigationModulesId, 'Orders', 'orders/settings');
    }
}
