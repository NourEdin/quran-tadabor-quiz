<?php

/*
  The plan:
  1. Make a loop of 30, in each:
    a. Read the file
    b. Explode
    c. Loop over rows starting from index 1 (not 0 which has the header). In each:
        1. Save cell 0 as question text
        2. Save cell 2 as answer text
        3. For each cell you have after 2, add an answer. If cell 1 is a single number, then all 
           answers have the same chapter. Otherwise, explode cell 1 by - and set each chapter to 
           an answer.
  2. Export as JSON and check
    
 */
$min = 1;
$max = 30;

for ($i=1; $i<=$max; $i++) {
    $filename = "Cleaning of Tadabor sheet v2 - $i.tsv";
    $filepath = __DIR__ . "/tsv/v2/$filename";
    $destpath = __DIR__ . "/json/v2/$i.json";
    $questions = [];
    if (file_exists($filepath)) {
        echo $filename . PHP_EOL;
        $pointer = fopen($filepath, "r");
        $row = fgetcsv($pointer, 0, "\t"); //skipping the first row
        while ($row = fgetcsv($pointer, 0, "\t")) {
            //Check if answers come from different suras
            $suras = explode("-", $row[1]);
            $surasCount = count($suras);
            $sura = $suras[0];

            //Generating answers array
            $answers = [];
            for ($j=3; $j<count($row); $j++) {
                if ($row[$j]) {
                    if ($surasCount > 1) 
                        $sura = $suras[$j-3]; //Match sura to its verse cell

                    $answers[] = [
                        "sura" => $sura,
                        "verse" => $row[$j]
                    ];
                }
            }

            //Replaces hashes (#) with <strong></strong>
            $answerText = preg_replace("/(#(.*?)#)/", "<strong>$2</strong>", $row[2]);

            $questions[] = [
                "text" => $row[0],
                "answerText" => $answerText,
                "answers" => $answers
            ];
        }
        fclose($pointer);
    } else {
        echo "Couldn't find $filepath" . PHP_EOL;
    }
    file_put_contents($destpath, json_encode($questions));

}