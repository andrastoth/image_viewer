<?php
if ($_REQUEST['order'] == 'file' && isset($_REQUEST['param']) == true) {
    $handle = opendir($_REQUEST['param'] . '/');
    $files  = '';
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && (getExtension($entry) == 'jpg' || getExtension($entry) == 'png')) {
            $files[] = array(
                'id' => 0,
                'name' => $entry
            );
        }
    }
    $data = json_encode($files);
    header('content-type: application/json');
    echo $data;
} elseif ($_REQUEST['order'] == 'file' && isset($_REQUEST['param']) == false) {
    $reqpic = $_REQUEST['dir'] . '/' . $_REQUEST['file'];
    $wid    = $_REQUEST['wh'];
    $hei    = $_REQUEST['he'];
    makeResizedImage($reqpic, $wid, $hei, 'file');
} elseif ($_REQUEST['order'] == 'database' && isset($_REQUEST['param']) == true) {
    $link = mysql_connect("server", "user", "pass") or die (mysql_error());
    mysql_select_db("database", $link);
    $res = mysql_query("SELECT image_name , id FROM pictures WHERE title =  'your selector'");
    while ($row = mysql_fetch_assoc($res)) {
        $data[] = array(
            'id' => $row['id'],
            'name' => $row['image_name']
        );
    }
    $data = json_encode($data);
    header('content-type: application/json');
    echo $data;
    mysql_close();
}
if ($_REQUEST['order'] == 'database' && isset($_REQUEST['param']) == false) {
    $reqpic = $_REQUEST['file'];
    $wid    = $_REQUEST['wh'];
    $hei    = $_REQUEST['he'];
     $id = $_REQUEST['id'];
    $link = mysql_connect("server", "user", "pass") or die (mysql_error());
    mysql_select_db("database", $link);
    $id    = $_REQUEST['id'];
    $image = mysql_query("SELECT image FROM pictures where id = $id");
    $image = mysql_fetch_assoc($image);
    $image = $image['image'];
    makeResizedImage($reqpic, $wid, $hei, $image);
    mysql_close();
}
function makeResizedImage($img_name, $new_w, $new_h, $conimage)
{
    $ext = getExtension($img_name);
    if ($conimage != 'file') {
        if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext))
            $src_img = imagecreatefromstring($conimage);
        if (!strcmp("png", $ext))
            $src_img = imagecreatefromstring($conimage);
    } else {
        if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext))
            $src_img = imagecreatefromjpeg($img_name);
        if (!strcmp("png", $ext))
            $src_img = imagecreatefrompng($img_name);
    }
    $old_x  = imageSX($src_img);
    $old_y  = imageSY($src_img);
    $ratio1 = $old_x / $new_w;
    $ratio2 = $old_y / $new_h;
    if ($ratio1 > $ratio2) {
        $thumb_w = $new_w;
        $thumb_h = $old_y / $ratio1;
    } else {
        $thumb_h = $new_h;
        $thumb_w = $old_x / $ratio2;
    }
    $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
    if (!strcmp("png", $ext)) {
        header('Content-Type: image/png');
        echo imagepng($dst_img, null, 100);
    } else {
        header('Content-Type: image/jpeg');
        echo imagejpeg($dst_img, null, 100);
    }
    imagedestroy($dst_img);
    imagedestroy($src_img);
}
function getExtension($str)
{
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l   = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return strtolower($ext);
}
?>