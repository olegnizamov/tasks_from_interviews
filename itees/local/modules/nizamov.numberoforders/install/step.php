<?if(!check_bitrix_sessid()) return;?>

<?
if($ex = $APPLICATION->GetException()) {
    echo CAdminMessage::ShowMessage([
        'TYPE' => 'ERROR',
        'MESSAGE' => 'Ошибка при установке модуля',
        'DETAILS' => $ex->GetString(),
        'HTML' => true
    ]);
} else {
    echo CAdminMessage::ShowNote("Модуль успешно установлен");
}
?>

<form action="<?=$APPLICATION->GetCurPage()?>">
    <input type="hidden" name="lang" value="<?=LANGUAGE_ID?>">
    <input type="submit" name="" value="Назад">
</form>
