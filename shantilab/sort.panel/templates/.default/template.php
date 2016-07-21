<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!$arResult['SORT_ITEMS']) return;

use \Bitrix\Main\Localization\Loc as Loc;
Loc::loadMessages(__FILE__);

echo Loc::getMessage('SORT_BY_HEAD');
?>
<?foreach($arResult['SORT_ITEMS'] as $item):?>
    <a href="<?=$item['url']['link']?>"><?=$item['name']?></a>
<?endforeach;?>