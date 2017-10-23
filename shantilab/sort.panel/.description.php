<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
    'NAME' => Loc::getMessage('FILTER_PANEL_COMPONENT_NAME'),
    'DESCRIPTION' => Loc::getMessage('FILTER_PANEL_COMPONENT_DESCRIPTION'),
    'SORT' => 10,
    'CACHE_PATH' => 'Y',
    'PATH' => array(
        'ID' => 'shantilab',
        'NAME' => Loc::getMessage('FILTER_PANEL_COMPONENT_MAIN_GROUP_NAME'),
    ),
);