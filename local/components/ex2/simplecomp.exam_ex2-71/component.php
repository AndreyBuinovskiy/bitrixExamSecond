<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if($this->startResultCache(false, array($USER->GetGroups())))
{
	
	//iblock elements
	$arSelectElems = array (
		"ID",
		"IBLOCK_ID",
		"NAME",
	);
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["CLASSIFICATOR_IBLOCK_ID"],
		"ACTIVE" => "Y",
		"CHECK_PERMISSIONS" => "Y"
	);
	$arSortElems = array ();
	
	$klassificatorId = [];
	$Klassificator = [];
	$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElements->GetNext())
	{
		$klassificatorId[] = $arElement['ID'];
		$arResult['ITEMS'][$arElement['ID']]["NAME"] = $arElement["NAME"];
	}
	
	if(!empty($klassificatorId)){
		//iblock elements
		$arSelectElems = array (
			"ID",
			"IBLOCK_ID",
			"NAME",
			"PROPERTY_".$arParams["PROP_CODE"],
			"PROPERTY_PRICE",
			"PROPERTY_MATERIAL",
			"PROPERTY_ARTNUMBER",
			"DETAIL_PAGE_URL"
		);
		$arFilterElems = array (
			"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
			"ACTIVE" => "Y",
			"PROPERTY_".$arParams["PROP_CODE"] => $klassificatorId,
			"CHECK_PERMISSIONS" => "Y"
		);
		$arSortElems = array ();
		
		$elementProduct = [];
		$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
		while($arElement = $rsElements->GetNext())
		{
			$arResult['ITEMS'][$arElement["PROPERTY_".$arParams["PROP_CODE"]."_VALUE"]]["PRODUCT"][$arElement['ID']] = [
				"NAME" => $arElement['NAME'],
				"PRICE" => $arElement['PROPERTY_PRICE_VALUE'],
				"MATERIAL" => $arElement['PROPERTY_MATERIAL_VALUE'],
				"ARTNUMBER" => $arElement['PROPERTY_ARTNUMBER_VALUE'],
				"DETAIL_PAGE_URL" => $arElement['DETAIL_PAGE_URL'],
			];
		}
		$arResult['COUNT_KLASSIFIKATOR'] = count($arResult['ITEMS']);
		
		$this->SetResultCacheKeys(array("COUNT_KLASSIFIKATOR"));
		$this->includeComponentTemplate();
	}
}

$APPLICATION->SetTitle(GetMessage("TITLE", array("#COUNT#" => $arResult['COUNT_KLASSIFIKATOR'])));
	
?>