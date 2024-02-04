<?php

require __DIR__ . '/config.php';
$address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

if (!in_array($address, WHITE_LIST_ADDRESS)) {
    echo json_encode(['success' => false, 'error_message' => 'У вас нет доступа к удалению файлов!' . $address, 'response' => null]);
    return;
}

if (!empty($_POST)) {
    $status = [];
    foreach ($_POST as $fileName) {
        $patch = __DIR__ . '/files/' . $fileName;
        if (file_exists($patch)){
            unlink($patch);
            $status[$fileName] = true;
        }else{
            $status[$fileName] = false;
        }
    }
    echo json_encode([
        'success' => true,
        'error_message' => null,
        'response' => [
            'status' => $status
        ]
    ]);
}else{
    echo json_encode(['success' => false, 'error_message' => 'Вы не передали названия файлов для удаления!', 'response' => null]);
}