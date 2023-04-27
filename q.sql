SELECT e.ID as id,
       ( REPLACE( REPLACE( REPLACE(i.DETAIL_PAGE_URL , "#SITE_DIR#", "%1$s"), "#SECTION_CODE#", t_section.CODE), "#ELEMENT_CODE#", e.CODE)) as url,
       CONCAT("%1$s","/upload/",f.SUBDIR, "/", f.FILE_NAME) as image,
       e.NAME as name,
       t_section.CODE as sectionName,
       e.ACTIVE_FROM as date, -- date Дата вида “12 декабря 2015 12:59” (день месяц год часы минуты)

       -- author - автор новости (свойство инфоблока типа “Привязка к элементам с автозаполнением”. Нужно вывести имя)
        ( SELECT ( SELECT SUBSTRING_INDEX(NAME, " ", 1) FROM b_iblock_element e WHERE PROPERTY_309 = e.ID )
            FROM b_iblock_element_prop_s%2$d prop
                WHERE prop.IBLOCK_ELEMENT_ID = e.ID
        ) as author,

        e.TAGS as tags -- решить с тэгами, массив тегов

FROM b_iblock_element e
    JOIN b_iblock i ON e.IBLOCK_ID = i.ID
    JOIN b_file f ON e.PREVIEW_PICTURE = f.ID
    JOIN b_iblock_section t_section ON e.IBLOCK_SECTION_ID = t_section.ID
WHERE e.IBLOCK_ID = %2$d
    AND ( e.ACTIVE_FROM >= "%3$s-01-01 " AND e.ACTIVE_FROM <= "%3$s-12-31") -- по дате
;