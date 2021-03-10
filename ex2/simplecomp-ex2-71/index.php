<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент ex2-71");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.exam_ex2-71",
	"",
	Array(
		"CACHE_TIME" => "8600",
		"CACHE_TYPE" => "A",
		"CLASSIFICATOR_IBLOCK_ID" => "7",
		"LINK_TEMPLATE" => "",
		"PRODUCTS_IBLOCK_ID" => "2",
		"PROP_CODE" => "FIRMA"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>