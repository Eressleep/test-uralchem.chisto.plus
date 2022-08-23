<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if (!check_bitrix_sessid()) {
    return;
}
echo(CAdminMessage::ShowNote(Loc::getMessage('URALCHEM_UNSTEP_BEFORE') . ' ' . Loc::getMessage('URALCHEM_UNSTEP_AFTER')));
?>

<form action='<?= $APPLICATION->GetCurPage() ?>'>
    <input type='hidden' name='lang' value='<?= LANG; ?>'/>
    <input type='submit' value='<?= Loc::getMessage('URALCHEM_UNSTEP_SUBMIT_BACK') ?>'>
</form>
