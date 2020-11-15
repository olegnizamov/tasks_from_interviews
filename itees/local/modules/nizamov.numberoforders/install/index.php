<?

use Bitrix\Main\ModuleManager,
    Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (class_exists("nizamov_numberoforders"))
    return;

class nizamov_numberoforders extends CModule
{

    function __construct()
    {
        $arModuleVersion = [];
        include(dirname(__FILE__) . "/version.php");

        $this->MODULE_ID = 'nizamov.numberoforders';
        $this->MODULE_NAME = 'Агент для периодического подсчета количества заказов';
        $this->MODULE_DESCRIPTION = 'Тестовое задание от Itees';
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
    }


    public function RegisterDepedencies()
    {
        CAgent::AddAgent("\Nizamov\Numberoforders\CheckAgent::getCurrentNumberOfOrders();", "nizamov.numberoforders", "N", 3600, '', 'Y');
    }

    public function CreateFile()
    {
        return RewriteFile($_SERVER["DOCUMENT_ROOT"] . "/orders.txt", "");
    }

    public function DeleteFile()
    {
        return DeleteDirFilesEx("orders.txt");
    }

    public function DoInstall()
    {
        global $APPLICATION;

        if (!CheckVersion(ModuleManager::getVersion('main'), '14.0.0')) {
            $APPLICATION->ThrowException('Ваша система не поддерживает D7');
        } else {
            ModuleManager::RegisterModule($this->MODULE_ID);
            $this->RegisterDepedencies();
            $this->CreateFile();
        }

        $APPLICATION->IncludeAdminFile(
            "Установка модуля Агента для периодического подсчета количества заказов",
            dirname(__FILE__) . "/step.php"
        );
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        \CAgent::RemoveModuleAgents("nizamov.numberoforders");
        $this->DeleteFile();

        $APPLICATION->IncludeAdminFile(
            "Деинсталляция модуля Агента для периодического подсчета количества заказов",
            dirname(__FILE__) . "/unstep.php"
        );
    }
}
