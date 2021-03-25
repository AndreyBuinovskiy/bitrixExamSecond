<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CLASSIFICATOR_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIFICATOR_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"LINK_TEMPLATE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_LINK_TEMPLATE"),
			"TYPE" => "STRING",
		),
		"PROP_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PROP_CODE"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => array("DEFAULT" => 8600),
	),
);