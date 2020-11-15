<?php

class NewCIblock
{
    public static function GetList($arOrder = array("SORT" => "ASC"), $arFilter = array(), $arGroupBy = false, $arNavStartParams = false, $arSelectFields = array())
    {

        if (CModule::IncludeModule("iblock")) {
            $obCache = new CPHPCache;
            $lifeTime = 60 * 10;

            if (!empty($arFilter['IBLOCK_ID'])) {
                $cacheID = $arFilter['IBLOCK_ID'];
            } else {
                $cacheID = "OlegNizamov";
            }

            if ($obCache->InitCache($lifeTime, $cacheID, "/")) {
                $vars = $obCache->GetVars();
                $resultarray = $vars["RESULT_ARRAY"];
            } else {
                echo "OLEGNIZAMOVWINN";
                $resultarray = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelectFields);
            }

            if ($obCache->StartDataCache()) {
                $obCache->EndDataCache(array(
                    "RESULT_ARRAY" => $resultarray
                ));
            }

            return $resultarray;
        }
        return false;
    }

    /*
     //Вызов работы метода
    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
    $arFilter = Array("IBLOCK_ID"=>IntVal("7"),"ID"=> '68',"ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = NewCIblock::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
    while($ob = $res->GetNextElement())
    {
    $arFields = $ob->GetFields();
    print_r($arFields);
    }
    */


}