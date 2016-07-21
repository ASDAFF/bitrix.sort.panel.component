# Bitrix components: sort.panel
---

## Описание
Модуль позволяет легко и бытро создать панель сортировки для списков (news.list, catalog.section)

## Установка
- Скопировать репозиторий в папку `/bitrix/components/` или `/local/components/`.
- Обновить кэш списка компонентов CMS 1C-Bitrix

## Использование
Разместитть на странице компонент shantilab:sort.panel
```php
$sortInfo = $APPLICATION->IncludeComponent("shantilab:sort.panel", "", [
    'SORT' => [
        [
            'name' => 'Цене',
            'url_code' => 'price',
            'bx_code' => 'CATALOG_PRICE_1',
            'order' => 'asc',
            'active' => true,
        ],
        [
            'name' => 'По алфавиту',
            'url_code' => 'name',
            'bx_code' => 'NAME',
            'order' => 'asc',
            'active' => false,
        ],
        [
            'name' => 'По популярности',
            'url_code' => 'popular',
            'bx_code' => 'SHOW_COUNTER',
            'order' => 'asc',
            'active' => false,
        ]
    ]
], false);
```
В переменной `$sortInfo` содержится массив с ключами для сортировки:

## Особенности
- Для удобной работы был создан базовый компонент панели сортировки с базовой логикой, которую при желании можно переписать или унаследовать в кмпонентах-классах потомках, например чтобы изменить место хранения текущей сортировки пользователя необходимо перегрзить 2 метода в class.php:
```php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

\CBitrixComponent::includeComponentClass("shantilab:base.sort.panel");

class SortPanelComponent extends \BaseSortPanelComponent
{
	protected function set($item){
    	parent::set($item);
        // Ваш код
    }

    protected function get(){
    	// Ваш код
        return parent::get()
    }
}
```

- Чтобы не использовать установку сортировки по умолчанию, необходимо переопределить переменную класса `$defaultSort`:
```php
class SortPanelComponent extends \BaseSortPanelComponent
{
	protected $defaultSort = false;
}

- Чтобы использовать мультисортировку, необходимо переопределить переменную класса `$multiSort`:
```php
class SortPanelComponent extends \BaseSortPanelComponent
{
    protected $multiSort = true;
}

- Чтобы не хранить сортировку в сессии необходимо переопределить переменную класса `$inSession`:
```php
class SortPanelComponent extends \BaseSortPanelComponent
{
    protected $inSession = false;
}

```
- Чтобы изменить ключ хранения сортировки в сессии пользователя, нужно переопределить переменную класса `$sessionKey`:
```php
class SortPanelComponent extends \BaseSortPanelComponent
{
	protected $sessionKey = 'shantilab_sort_panel';
}

```

## Примечание
Можно создавать отдельные компоненты-классы основанные на базовом компоненте-классе сортировки, для этого необходимо создать компонент с файлом `class.php` сожержания:

```php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

\CBitrixComponent::includeComponentClass("shantilab:base.sort.panel");

class SortPanelComponent extends \BaseSortPanelComponent
{
	//Ваш код
}
```
