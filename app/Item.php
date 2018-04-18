<?php

namespace App;

use DB;

class Item extends SqlModel
{
    protected $table = 'THE_SetItem';
    
    public static function getTwos()
    {
        return self::getAll("LEFT(i.acIdent, 1) IN ('2') AND");
    }

    public static function getSevens()
    {
        return self::getAll("LEFT(i.acIdent, 1) IN ('7') AND");
    }
    
    public static function getOthers()
    {
        return self::getAll("LEFT(i.acIdent, 1) NOT IN ('2', '7') AND");
    }

    public static function getAll($where = '')
    {
        $data = DB::select("
            SELECT --TOP 100
                RTRIM(i.acIdent) AS ident,
                RTRIM(v.acCode) AS ean,
                RTRIM(i.acCode) AS supplierCode,
                RTRIM(i.acName) AS name,
                s.anStock AS stock,
                i.anSalePrice AS price,
                i.anDiscount AS discount,
                c.acName AS category,
                u.acName AS subCategory,
                i.acFieldSA AS brand,
                i.acFieldSC AS importedFrom,
                i.acFieldSE AS material,
                i.acDescr AS description,
                i.acUM AS unit
            FROM tHE_SetItem i
            LEFT JOIN tHE_SetItemCateg AS c ON c.acClassif = i.acClassif AND c.acType = 'P'
            LEFT JOIN tHE_SetItemCateg AS u ON u.acClassif = i.acClassif2 AND u.acType = 'S'
            FULL OUTER JOIN tHE_SetItemExtItemSubj v ON v.acIdent = i.acIdent
            LEFT JOIN
                (
                    SELECT st.acIdent, SUM(st.anStock) AS anStock
                    FROM tHE_Stock st
                    WHERE st.acWarehouse IN
                            (
                                'MP Lamiacasa',
                                'MP Elko Tim H. Novi',
                                'MP Elko Tim Budva',
                                'MP Elko Tim Podgorica'
                            )
                    GROUP BY st.acIdent
                ) s ON s.acIdent = i.acIdent
            WHERE
                {$where}
                i.acIdent <> '' AND
                i.acActive = 'T' AND
                s.anStock >= 0
            ORDER BY
                i.acCode ASC,
                RTRIM(i.acIdent) ASC
        ");

        return collect(json_decode(json_encode($data), true));
    }
}
