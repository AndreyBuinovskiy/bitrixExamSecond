<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SPECIALDATE" => Array(
		"NAME" => GetMessage("SPECIALDATE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
	),
	"ID_INFOBLOCK_REL_CANONICAL" => Array(
		"NAME" => GetMessage("ID_INFOBLOCK_REL_CANONICAL"),
		"TYPE" => "TEXT",
		"VALUE" => "",
	),
);
?>
