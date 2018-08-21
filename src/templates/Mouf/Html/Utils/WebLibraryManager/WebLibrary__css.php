<?php
$files = $object->getCssFiles();
if ($files) {
    foreach ($files as $file) {
        if (strpos($file, 'http://') === false && strpos($file, 'https://') === false && strpos($file, '/') !== 0) {
            $url = ROOT_URL.$file;
        } else {
            $url = $file;
        }
        echo "<link href='".htmlspecialchars($url, ENT_QUOTES)."' rel='stylesheet' type='text/css' />\n";
    }
}
