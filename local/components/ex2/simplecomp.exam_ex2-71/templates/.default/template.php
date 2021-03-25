<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?if(!empty($arResult['ITEMS'])){?>
    <ul>
        <?foreach($arResult['ITEMS'] as $klassifikator){?>
            <li><b><?=$klassifikator["NAME"];?></b>
                <ul>
                    <?foreach($klassifikator["PRODUCT"] as $prod){?>
                        <li><b><?=$prod["NAME"]?></b> - <?=$prod["PRICE"]?> - <?=$prod["MATERIAL"]?> - <?=$prod["ARTNUMBER"]?> (<?=$prod["DETAIL_PAGE_URL"]?>)</li>
                    <?}?>
                </ul>
            </li>
        <?}?>
    </ul>
<?}else{?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_EMPTY")?></b></p>
<?}?>