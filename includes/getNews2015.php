<?php
/** php 8.1 */

// Использую код инфоблока, Вместо id 12 , т.к. могут быть раные идентификаторы при миграции на сервер.
$i_block_code = 'NEWS';

\Bitrix\Main\Loader::includeModule('iblock') ?? throw new \Exception('Модуль инфоблока не найден.', 500);

$id = \CIBlock::GetList(
    [],
    ['CODE' => $i_block_code],
)->fetch();

// Так как глюк с правами инфоблока на сайте, ставлю 55 по умолчанию, в рамках теста
$i_block_id = $id['ID'] ?? 55;

// год выборки
$filter_years = '2015';

$connection = \Bitrix\Main\Application::getConnection();
$SITE_DIR = 'http://' . $_SERVER['HTTP_HOST'];

// для данных
$arData = [];

$sql = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/q.sql');

// region Стучимся в базу
$result = $connection->query(sprintf($sql, $SITE_DIR, $i_block_id, $filter_years));

while($ar = $result->fetch())
{
    // тут битриксовский объект времени
    $ar['date'] = \FormatDate("d F Y H:i", $ar['date']->getTimestamp());
    // тут делим так как в базе нет методов
    $ar['tags'] = explode( ',' , $ar['tags']);
    $arData[] = $ar;
}

//endregion
/** @var object $json_result Ответ в строке JSON */
$json_response = json_encode($arData);
header(header: 'Content-Type: application/json', response_code: 200);
echo $json_response;
exit;