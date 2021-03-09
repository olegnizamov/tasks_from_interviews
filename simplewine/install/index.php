<?php

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;
use Nizamov\ExtraOrderInfo\Handler\AdminTab;
use Nizamov\ExtraOrderInfo\Handler\Order;

Loc::loadMessages(__FILE__);

class nizamov_extraorderinfo extends CModule
{
    public $arModuleVersion;
    public $MODULE_ID = "nizamov.extraorderinfo";

    function __construct()
    {
        $arModuleVersion = [];
        include(dirname(__FILE__) . "/version.php");
        $this->MODULE_PATH = $this->GetPath(false);
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::GetMessage("MOBILE_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::GetMessage("MODULE_DESCRIPTION");
        $this->MODULE_ID = 'nizamov.extraorderinfo';
        $this->PARTNER_NAME = Loc::GetMessage("PARTNER_NAME");
        $this->PARTNER_URI = Loc::GetMessage("PARTNER_URI");
        $this->MODULE_SORT = 1;
    }

    /**
     * Install
     */
    public function DoInstall()
    {
        global $APPLICATION;
        if (!CheckVersion(ModuleManager::getVersion('main'), '14.0.0')) {
            $APPLICATION->ThrowException('Ваша система не поддерживает D7');
        }
        ModuleManager::registerModule($this->MODULE_ID);
        $this->InstallEvents();
        $this->InstallDB();
    }

    /**
     * Delete
     */
    public function DoUninstall()
    {
        $this->UnInstallEvents();
        $this->UnInstallDB();
        COption::RemoveOption($this->MODULE_ID);
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    /**
     * Установка базы данных
     *
     * @return false|void
     */
    public function InstallDB()
    {
        global $DB;
        $DB->Query(
            '
            CREATE TABLE if NOT EXISTS extra_order_ip_info
            (
                ID BIGINT(20) NOT NULL auto_increment,
                ORDER_ID BIGINT(20) NOT NULL,
                IP VARCHAR(100) NOT NULL,
                IP_INFO LONGTEXT,
                PRIMARY KEY (ID)
            )
        '
        );
    }

    /**
     * Удаление таблицы
     */
    public function UnInstallDB()
    {
        global $DB;
        $DB->Query('DROP TABLE if EXISTS extra_order_ip_info');
    }

    /**
     * Получение пути
     * @param false $notDocumentRoot
     * @return string|string[]
     */
    public function GetPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot) {
            return str_ireplace(Application::getDocumentRoot(), '', str_replace("\\", "/", dirname(__DIR__)));
        } else {
            return dirname(__DIR__);
        }
    }

    /**
     * Установка событий
     */
    public function InstallEvents(): void
    {
        if (CModule::IncludeModule('sale')) {
            RegisterModuleDependences(
                'sale',
                'OnOrderAdd',
                $this->MODULE_ID,
                Order::class,
                'OnOrderAddHandler'
            );
        }

        if (CModule::IncludeModule('main')) {
            RegisterModuleDependences(
                'main',
                'OnAdminSaleOrderView',
                $this->MODULE_ID,
                AdminTab::class,
                'OnAdminSaleOrderViewHandler'
            );
        }
    }

    /**
     * Удаление событий
     */
    public function UnInstallEvents(): void
    {
        UnRegisterModuleDependences(
            'sale',
            'OnOrderAdd',
            $this->MODULE_ID,
            Order::class,
            'OnOrderAddHandler'
        );
        UnRegisterModuleDependences(
            'main',
            'OnAdminSaleOrderView',
            $this->MODULE_ID,
            AdminTab::class,
            'OnAdminSaleOrderViewHandler'
        );
    }
}