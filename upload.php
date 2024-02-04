<?php

require __DIR__ . '/config.php';
$address = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

if (!in_array($address, WHITE_LIST_ADDRESS)) {
    echo json_encode(['success' => false, 'error_message' => 'У вас нет доступа к загрузке файлов!', 'response' => null]);
    return;
}

if (!empty($_FILES)) {
    $url = [];
    $allSize = 0;
    foreach ($_FILES as $fileData) {
        $fileName = $fileData['name'];
        $tmp_name = $fileData['tmp_name'];
        $size = $fileData['size'];//bytes
        move_uploaded_file($tmp_name, __DIR__ . '/files/' . $fileName);
        $allSize += $size;
        $url[$fileName] = DOMAIN_NAME . '/files/' . $fileName;
    }

    echo json_encode([
        'success' => true,
        'error_message' => null,
        'response' =>
            [
                'message' => 'Успешно переданы файлы',
                'url' => $url,
                'all_size' => $allSize
            ]
    ]);
} else {
    echo json_encode(['success' => false, 'error_message' => 'Файлы к загрузке небыло переданы!', 'response' => null]);
}