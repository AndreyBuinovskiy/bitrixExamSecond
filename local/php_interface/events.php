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

AddEventHandler("main", "OnBeforeEventAdd", array("EventAdd", "OnBeforeEventAddHandler"));
class EventAdd
{
	function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
	{
        if($event == "FEEDBACK_FORM"){
            global  $USER;
            if($USER->IsAuthorized()){
                $arFields["AUTHOR"] = GetMessage('IS_AUTHORISE',
                                                 array(
                                                       '#USER_ID#' => $USER->GetID(),
                                                       '#USER_LOGIN#' => $USER->GetLogin(),
                                                       '#USER_NAME#' => $USER->GetFirstName(),
                                                       '#AUTHOR#' => $arFields["AUTHOR"]
                                                    )
                                                 );
            }else{
                $arFields["AUTHOR"] = GetMessage('NOT_AUTHORISE', array('#AUTHOR#' => $arFields["AUTHOR"]));
            }
            
            CEventLog::Add(array(
                "SEVERITY" => "EVENT",
                "AUDIT_TYPE_ID" => "AUTHOR",
                "MODULE_ID" => "main",
                "DESCRIPTION" => $arFields["AUTHOR"],
            ));
            
        }
        
	}
}