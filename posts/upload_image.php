<?php
$target_dir = "../uploads/";
if(!is_dir($target_dir)) mkdir($target_dir, 0755, true);

if(isset($_FILES['file'])){
    $file_name = time() . "_" . basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;

    if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
        echo json_encode(['location' => 'uploads/' . $file_name]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo subir la imagen']);
    }
}
?>
