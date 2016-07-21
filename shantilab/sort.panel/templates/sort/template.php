<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!$arResult['SORT_ITEMS']) return;

use \Bitrix\Main\Localization\Loc as Loc;
Loc::loadMessages(__FILE__);
?>
<div class="content_page_title_select">
    <select class="dropdown sorting">
        <option value="" class="label"><?=Loc::getMessage('SORT_BY_HEAD')?></option>
        <?foreach($arResult['SORT_ITEMS'] as $item):?>
            <?if ($item['url_code'] == 'price'):?>
                <option <?=($item['active'] && $item['order'] == 'asc') ? 'selected' : ''?> data-link="<?=$APPLICATION->GetCurPageParam($item['url_code'] . '=asc', [$item['url_code']]);?>"><?=$item['name']?> (дешевле &#8594; дороже)</option>
                <option <?=($item['active'] && $item['order'] == 'desc') ? 'selected' : ''?> data-link="<?=$APPLICATION->GetCurPageParam($item['url_code'] . '=desc', [$item['url_code']])?>"><?=$item['name']?> (дороже &#8594; дешевле)</option>
            <?else:?>
                <option <?=($item['active']) ? 'selected' : ''?> data-link="<?=$item['url']['link']?>"><?=$item['name']?></option>
            <?endif;?>
        <?endforeach?>
    </select>
</div>