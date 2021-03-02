<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

// регистрируем обработчик
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("ElementUpdate", "OnBeforeIBlockElementUpdateHandler"));

class ElementUpdate
{
    // создаем обработчик события "OnBeforeIBlockElementUpdate"
    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        
        if($arFields['ACTIVE'] == "N"){
            $counter = 0;
            $res = CIBlockElement::GetByID($arFields["ID"]);
            if($ar_res = $res->GetNext()){
                $counter = $ar_res["SHOW_COUNTER"];
            }
            if($counter > 2)
            {
                global $APPLICATION;
                $APPLICATION->throwException(GetMessage('UPDAT_ELEMENT', array('#COUNT#' => $ar_res["SHOW_COUNTER"])));
                return false;
            }
        }
    }
}