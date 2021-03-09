<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<ul>
    <?foreach($arResult["ITEMS"] as $news):?>
            <li><b><?=$news["NAME"]?></b> - <?=$news["DATE_ACTIVE"]?>
                (
                    <?foreach($news["SECTION"] as $section):?>
                        <?=$section["NAME"]?>,
                    <?endforeach;?>
                )
            
                <ul>
                    <?foreach($news["PRODUCT"] as $product):?>
                       <li><?=$product["NAME"]?> - <?=$product["PRICE"]?> - <?=$product["MATERIAL"]?> - <?=$product["ARTNUMBER"]?></li>
                    <?endforeach;?>
                </ul>
            </li>
    <?endforeach;?>
</ul>