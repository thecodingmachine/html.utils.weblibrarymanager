<?php
$files = $object->getJsFiles();
if ($files) {
    foreach ($files as $file) {
        if (strpos($file, 'http://') === false && strpos($file, 'https://') === false && strpos($file, '/') !== 0) {
            $url = $object->getRootUrl().$file;
        } else {
            $url = $file;
        }
        echo '<script type="text/javascript" src="'.htmlspecialchars($url, ENT_QUOTES).'" '.($object->isAsync()?'async':'').'></script>'."\n";
    }
}
