<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

if(!empty($arParams["NEWS_IBLOCK_ID"]) && $this->startResultCache())
{
	
	//iblock elements
	$arSelectElems = array (
		"ID",
		"DATE_ACTIVE_FROM",
		"NAME",
	);
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
		"ACTIVE" => "Y",
	);
	
	$arSortElems = array ();
	
	$news = [];
	$newsId = [];
	$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElements->GetNext())
	{
		
		$newsId[] = $arElement['ID']; 
		$news[$arElement["ID"]] =[
			'NAME' => $arElement["NAME"],
			'DATE_ACTIVE' => $arElement["DATE_ACTIVE_FROM"],
		];
	}
	
	//iblock sections
	$arSelectSect = array (
			"ID",
			"IBLOCK_ID",
			"NAME",
			"UF_".$arParams['PROPERTY_CLASSIFIKATOR'],
	);
	$arFilterSect = array (
			"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
			"ACTIVE" => "Y",
			"UF_".$arParams['PROPERTY_CLASSIFIKATOR'] => $newsId,
	);
	
	$arSections = [];
	$sectionId = [];
	$rsSections = CIBlockSection::GetList($arSortSect, $arFilterSect, false, $arSelectSect, false);
	while($arSection = $rsSections->GetNext())
	{
		$sectionId[] = $arSection["ID"];
		$arSections[$arSection["ID"]] = [
			"NAME" => $arSection["NAME"],
			"UF_".$arParams['PROPERTY_CLASSIFIKATOR'] => $arSection["UF_".$arParams['PROPERTY_CLASSIFIKATOR']],
		];
	}
	
	//iblock elements
	$arSelectElems = array (
		"ID",
		"NAME",
		"PROPERTY_ARTNUMBER",
		"PROPERTY_MATERIAL",
		"PROPERTY_PRICE",
		"IBLOCK_SECTION_ID",
	);
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
		"ACTIVE" => "Y",
		"SECTION_ID" => $sectionId,
	);
	$arSortElems = array ();
	
	$product = [];
	$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElements->GetNext())
	{

		$product[] =[
			'NAME' => $arElement["NAME"],
			'ARTNUMBER' => $arElement["PROPERTY_ARTNUMBER_VALUE"],
			'MATERIAL' => $arElement["PROPERTY_MATERIAL_VALUE"],
			'PRICE' => $arElement["PROPERTY_PRICE_VALUE"],
			'SECTION_ID' => $arElement["IBLOCK_SECTION_ID"],
		];
	}
	
	$arResult["ITEMS"] = [];
	foreach($news as $newsId=> $newsItem){
		$arResult["ITEMS"][$newsId] = $newsItem;
		foreach($arSections as $sectionId => $sectionItem){
			if(in_array($newsId, $sectionItem["UF_".$arParams['PROPERTY_CLASSIFIKATOR']])){
				$arResult["ITEMS"][$newsId]["SECTION"][$sectionId]["NAME"] = $sectionItem["NAME"];
				$secId[] = $sectionId;
			}
		}
		
		foreach($product as $productItem){
			if(in_array($productItem["SECTION_ID"], $secId)){
				$arResult["ITEMS"][$newsId]["PRODUCT"][] = $productItem;
			}
		}
	}
	
	$arResult["COUNT_PRODUCT"] = count($product);
	$this->SetResultCacheKeys(array(
		"COUNT_PRODUCT",
	));
		 
	$this->includeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_TITLE", array("#COUNT#" => $arResult["COUNT_PRODUCT"])));

?>