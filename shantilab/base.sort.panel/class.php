<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

class BaseSortPanelComponent extends \CBitrixComponent
{
    protected $sessionKey = 'shantilab_sort_panel';
    protected $multiSort = false;
    protected $inSession = true;
    protected $defaultSort = true;
    protected $type = 'list_items';

    public function onIncludeComponentLang()
    {
        $this->includeComponentLang(basename(__FILE__));
        Loc::loadMessages(__FILE__);
    }

    public function onPrepareComponentParams($params)
    {
        if (isset($params['TYPE']) && strlen($params['TYPE']) > 0)
            $this->sortType = htmlspecialcharsbx($params['TYPE']);

        if (isset($params['SORT']) && is_array($params['SORT']))
            $this->sortItems = $params['SORT'];

        return $params;
    }

    protected function getResult()
    {
        if (!is_array($this->sortItems)) return;

        if ($this->inSession && $_SESSION[$this->sessionKey]['sort_' . $this->type])
            $this->sortItems = $_SESSION[$this->sessionKey]['sort_' . $this->type];

        $this->prepareData();
        $this->makeActive();
        $this->makeUrls();

        $this->arResult['SORT_ITEMS'] = $this->sortItems;

        if ($this->inSession)
            $_SESSION[$this->sessionKey]['sort_' . $this->type] = $this->sortItems;
    }

    protected function makeActive(){
        foreach ($this->sortItems as $key => $item){
            $this->sortItems[$key]['new_order'] = (toLower($item['order']) == 'asc') ? 'desc' : 'asc';
        }

        $codesFromUrl = $this->getCodesFromUrl();

        if ($codesFromUrl){
            foreach ($this->sortItems as $item){
                if (in_array($item['url_code'], $codesFromUrl)){
                    $this->setItemSort($item);

                    if (!$this->multiSort)
                        break;
                }
            }
        }else{
            foreach ($this->sortItems as $item){
                if ($item['active']){
                    $this->setItemSort($item);

                    if (!$this->multiSort)
                        break;
                }
            }
        }
    }

    protected function setItemSort($item){
        if (!$this->multiSort)
            $this->resetActive();

        $item['active'] = true;

        if(isset($_REQUEST[$item['url_code']])){
            $requestOrder = toLower(htmlspecialcharsbx($_REQUEST[$item['url_code']]));
            $item['order'] = ($requestOrder == 'asc') ? 'asc' : 'desc';
        }

        $item['new_order'] = (toLower($item['order']) == 'asc') ? 'desc' : 'asc';

        $this->set($item);
    }

    protected function getSort(){
        if ($this->multiSort){
            return $this->sortItems;
        }

        $codesFromUrl = $this->getCodesFromUrl();
        if ($codesFromUrl || $this->defaultSort){
            foreach ($this->sortItems as $item){
                if ($item['active'])
                    return $item;
            }
        }
    }

    protected function prepareData()
    {
        foreach($this->sortItems as &$item){
            if ($this->multiSort)
                $item['active'] = true;
        }
        reset($this->sortItems);
    }

    protected function makeUrls(){
        foreach ($this->sortItems as $key => $item){
            $this->sortItems[$key]['url'] = $this->getLink($item);
        }
        reset($this->sortItems);
    }

    protected function getLink($item){
        global $APPLICATION;

        if ($this->multiSort){
            $params = [];
            foreach ($this->sortItems as $val){
                $order = $val['order'];
                if ($item['url_code'] == $val['url_code'])
                    $order = $val['new_order'];

                $link['query_params'][] = [
                    $val['url_code'] => $order
                ];

                $params[] = implode('=', [$val['url_code'], $order]);
            }

            $link['link'] = $APPLICATION->GetCurPageParam(implode('&', $params), [$this->getUrlCodesFromItems()]);
        }else{
            $link['query_params'] = [
                $item['url_code'] => $item['new_order']
            ];
            $link['link'] = $APPLICATION->GetCurPageParam($item['url_code'] . '=' . $item['new_order'], [$this->getUrlCodesFromItems()]);
        }

        return $link;
    }

    protected function getUrlCodesFromItems()
    {
        $urlCodes = [];

        foreach ($this->sortItems as $item){
            if (!in_array($item['url_code'], $urlCodes))
                $urlCodes[] = $item['url_code'];
        }

        return $urlCodes;
    }

    protected function resetActive()
    {
        $this->sortItems = array_map(function($item){
            $item['active'] = false;
            return $item;
        }, $this->sortItems);
    }

    protected function getCodesFromUrl(){
        global $APPLICATION;

        $query = [];
        $parts = parse_url($APPLICATION->getCurPageParam());
        parse_str($parts['query'], $query);

        return array_intersect($this->getUrlCodesFromItems($this->sortItems), array_keys($query));
    }

    public function get(){
        return $this->getSort();
    }

    public function set($item){
        foreach($this->sortItems as $key => $val){
            if ($val['url_code'] == $item['url_code'])
                $this->sortItems[$key] = $item;
        }
    }

    public function executeComponent()
    {
        try
        {
            $this->getResult();
            $this->includeComponentTemplate();
            return $this->get();
        }
        catch (Exception $e)
        {
            ShowError($e->getMessage());
        }
    }
}