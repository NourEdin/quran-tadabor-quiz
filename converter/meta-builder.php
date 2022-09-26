<?php

/*
API: http://api.alquran.cloud/v1/meta
The plan:
    1. Build suras.json to be an array of {name, ayaCount}
    2. Build juzs.json to be an array of {startSura, startAya, suraCount}
*/
//Fetchig meta
echo "fetching content .." . PHP_EOL;
$meta = file_get_contents(__DIR__ . "/meta/meta.json");
echo "decoding content .." . PHP_EOL;
$meta = json_decode($meta, true);
$meta = $meta['data'];
$surasSrc = $meta['surahs'];
$suras = [];
$juzsSrc = $meta['juzs'];
$juzs = [];
unset($meta);

//Building suras.json
foreach ($surasSrc['references'] as $sura) {
    $suras[] = [
        "name" => $sura['name'],
        "ayaCount" => $sura['numberOfAyahs']
    ];
}

//Building juzs.json
foreach ($juzsSrc['references'] as $i => $juz) {
    $startSura = $juz['surah'];
    $startAya = $juz['ayah'];
    $lastSura = ($i == 29) ? 114 : $juzsSrc['references'][$i+1]['surah'];
    $suraCount = $lastSura - $startSura + 1;
    
    $juzs[] = [
        "startSura" => $startSura,
        "startAya" => $startAya,
        "suraCount" => $suraCount
    ];
}

file_put_contents(__DIR__ . "/meta/juzs.json", json_encode($juzs));
file_put_contents(__DIR__ . "/meta/suras.json", json_encode($suras));