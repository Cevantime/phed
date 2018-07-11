<?php

if (!file_exists('./application/cache')) {
	mkdir('./assets/cache');
}
if (!file_exists('./application/cache/pdfthumbs')) {
	mkdir('./assets/cache/pdfsthumbs');
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./application/cache'));

foreach($iterator as $item) {
    chmod($item, "0777");
}