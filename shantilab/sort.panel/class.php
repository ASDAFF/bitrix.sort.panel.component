<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Site\Data;

\CBitrixComponent::includeComponentClass("shantilab:base.sort.panel");

class SortPanelComponent extends \BaseSortPanelComponent
{
    protected $defaultSort = true;
    protected $multiSort = false;
    protected $inSession = true;
    protected $sortItems = [
        [
            'name' => 'По цене',
            'url_code' => 'price',
            'bx_code' => 'CATALOG_PRICE_1',
            'order' => 'asc',
            'active' => true,
        ],
        [
            'name' => 'По рейтингу',
            'url_code' => 'rating',
            'bx_code' => '__EMP_',
            'order' => 'desc',
            'active' => false,
        ],
        [
            'name' => 'По отзывам',
            'url_code' => 'reviews',
            'bx_code' => '__EMP',
            'order' => 'desc',
            'active' => false,
        ]
    ];

    public function set($item)
    {
        parent::set($item);
        Data::set('catalog_sort', $item);
    }
}