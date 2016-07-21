<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc as Loc;
Loc::loadMessages(__FILE__);

$arComponentParameters = [
	"GROUPS" => [],
	"PARAMETERS" => [
        "SORT" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage('SHANTILAB_SORT_PANEL_ARRAY'),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ],
        "TYPE" => [
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage('SHANTILAB_SORT_PANEL_TYPE'),
            "TYPE" => "STRING",
            "DEFAULT" => "list_items",
        ],
	],
];