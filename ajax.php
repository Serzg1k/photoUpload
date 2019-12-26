<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Database.php';
$pdo = Database::getInstance();
if($_POST['callback'] === 'insert'){
    echo insertImage();
}elseif ($_POST['callback'] === 'pagination'){
    echo $pdo->getHtml($_POST['page'], 10);
}elseif($_POST['callback'] === 'views'){
    $pdo->viewImageById($_POST['imageId'], $_POST['views']);
}elseif ($_POST['callback'] === 'filter'){
    $and = '';
    $minH = isset($_POST['minH'])?$_POST['minH']:false;
    $maxH = isset($_POST['maxH'])?$_POST['maxH']:false;
    $minW = isset($_POST['minW'])?$_POST['minW']:false;
    $maxW = isset($_POST['maxW'])?$_POST['maxW']:false;
    $views = isset($_POST['views'])?$_POST['views']:false;
    if($minH){
        $and .= "AND `key` = 'height' AND `value` > {$minH} ";
    }
    if ($maxH){
        $and .= "AND `key` = 'height' AND `value` < {$maxH} ";
    }
    if ($minW){
        $and .= "AND `key` = 'width' AND `value` > {$minW} ";
    }
    if ($maxW){
        $and .= "AND `key` = 'width' AND `value` < {$maxW} ";
    }
    if ($views){
        $and .= "AND `key` = 'views' AND `value` > {$views} ";
    }
    print_r($and);
    print_r($pdo->getIdsByFilters($and));
}

function insertImage(){
    $width = getimagesize($_FILES['file']['tmp_name'])[0];
    $height = getimagesize($_FILES['file']['tmp_name'])[1];
    $name = $_FILES['file']['name'];
    $upload = new \Delight\FileUpload\FileUpload();
    $size = $upload->getMaximumSizeInBytes();
    $upload->withTargetDirectory(__DIR__ . '/upload');
    $upload->withMaximumSizeInMegabytes(5);
    $upload->withAllowedExtensions([ 'jpeg', 'jpg', 'png', 'gif', 'bmp' ]);
    $upload->from('file');
    $uploadedFile = $upload->save();
    $pdo = Database::getInstance();

    $data_id = $pdo->insertImagesData([$_FILES['file']['name']]);
    $pdo->insertAttrsData([$data_id,'name',$uploadedFile->getFilenameWithExtension()]);
    $pdo->insertAttrsData([$data_id,'size',$size]);
    $pdo->insertAttrsData([$data_id,'views',0]);
    $pdo->insertAttrsData([$data_id,'height',$height]);
    $pdo->insertAttrsData([$data_id,'width',$width]);

    return imageHtml($data_id, $uploadedFile->getFilenameWithExtension());
}

function imageHtml($id, $src){
    ob_start();
    ?>
    <div class="col-md-2">
        <div class="card mb-4 box-shadow">
            <img data-id="<?= $id ?>" class="card-img-top" style="height: 100px; width: 100%; display: block;" src="/upload/<?= $src ?>" data-holder-rendered="true">
        </div>
    </div>
    <?php
    return ob_get_clean();
    }