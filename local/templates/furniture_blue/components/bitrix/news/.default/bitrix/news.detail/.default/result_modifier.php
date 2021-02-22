<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arParams['ID_INFOBLOCK_REL_CANONICAL'])){
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array("IBLOCK_ID"=>IntVal($arParams['ID_INFOBLOCK_REL_CANONICAL']), "PROPERTY_NEWS"=>$arResult['ID'], "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNext()){ 
        $arResult['LINK_CANONICAL'] = $ob['NAME'];
    }
    $cp = $this->__component;
    $cp->SetResultCacheKeys(array(
        "LINK_CANONICAL",
    ));
    
}