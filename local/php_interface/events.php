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

AddEventHandler("main", "OnBuildGlobalMenu", "OnBuildGlobalMenuEventHendler");

function OnBuildGlobalMenuEventHendler(&$aGlobalMenu, &$aModuleMenu){
     global $USER;
     if($USER->IsAdmin())
      return;
    
    
    $userGroup = CUser::GetUserGroup($USER->GetId());
    if(!in_array(5, $userGroup)){
       return;
    }
    

    unset($aGlobalMenu['global_menu_desktop']);
    foreach($aModuleMenu as $key=>$item){
        if($item['text'] == "Инфоблоки"){
            unset($aModuleMenu[$key]);
        }
    }
    
}


//инструмент СЕО специалиста
AddEventHandler("main", "OnEpilog", "functionOnEpilog");
function functionOnEpilog(){
    
    if(!CModule::includeModule('iblock')){
        return;
    }
    
    global $APPLICATION;
    
    $arSelect = Array("ID", "NAME", "PROPERTY_TITLE", "PROPERTY_DESCRIPTION");
    $arFilter = Array("IBLOCK_ID"=>6, "=NAME"=>$APPLICATION->GetCurPage(), "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    if($ob = $res->GetNext())
    {
        $APPLICATION->SetTitle($ob["PROPERTY_TITLE_VALUE"]);
        $APPLICATION->SetPageProperty('description', $ob["PROPERTY_DESCRIPTION_VALUE"]);
    }
}