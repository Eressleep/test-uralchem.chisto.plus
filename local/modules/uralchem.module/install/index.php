<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Uralchem\Module\Tables\JwtTable;

class uralchem_module extends CModule
{

    public function __construct()
    {
        if (file_exists(__DIR__ . '/version.php')) {
            $arModuleVersion = [];
            include_once(__DIR__ . '/version.php');

            if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
                $this->MODULE_VERSION = $arModuleVersion['VERSION'];
                $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
            }

            $this->MODULE_ID = str_replace('_', '.', __CLASS__);

            $this->MODULE_NAME = Loc::getMessage('URALCHEM_NAME');
            $this->MODULE_DESCRIPTION = Loc::getMessage('URALCHEM_DESCRIPTION');

            $this->PARTNER_NAME = Loc::getMessage('URALCHEM_PARTNER_NAME');
            $this->PARTNER_URI = Loc::getMessage('URALCHEM_PARTNER_URI');

            $this->MODULE_SORT = 1;
            $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
            $this->MODULE_GROUP_RIGHTS = 'Y';
        }
    }



    public function DoInstall()
    {
        global $APPLICATION;

        if (CheckVersion(ModuleManager::getVersion('main'), '14.00.00')) {
            ModuleManager::registerModule($this->MODULE_ID);

            if (Loader::includeModule($this->MODULE_ID)) {
                $this->InstallDB();
            }
        } else {
            $APPLICATION->ThrowException(
                Loc::getMessage('URALCHEM_INSTALL_ERROR_VERSION')
            );
        }

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('URALCHEM_INSTALL_TITLE') . ' \'' . Loc::getMessage('URALCHEM_NAME') . '\'',
            __DIR__ . '/step.php'
        );
    }
    public function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        if (!Application::getConnection()->isTableExists(
            Base::getInstance(JwtTable::getEntity()->getDataClass())->getDBTableName()
        )) {
            JwtTable::getEntity()->createDbTable();
        }
    }

    public function DoUninstall()
    {
        global $APPLICATION;

        if (Loader::includeModule($this->MODULE_ID)) {
            $this->UnInstallDB();
        }
        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage('URALCHEM_UNINSTALL_TITLE') . ' \'' . Loc::getMessage('URALCHEM_NAME') . '\'',
            __DIR__ . '/unset.php'
        );

        return false;
    }

    public function UnInstallDB()
    {
        if (Application::getConnection()->isTableExists(
            Base::getInstance(JwtTable::getEntity()->getDataClass())->getDBTableName()
        )) {
            $connection = Application::getInstance()->getConnection();
            $connection->dropTable(JwtTable::getTableName());
        }

        Option::delete($this->MODULE_ID);
    }


}
