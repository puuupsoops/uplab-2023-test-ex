<?php
try{
    require_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/getNews2015.php';
}catch (\Exception $e){
    header(header: 'Content-Type: application/json', response_code: 500);
    echo json_encode(['error' => [ 'code' => $e->getCode(), 'message' => $e->getMessage()]]);
    exit;
}
