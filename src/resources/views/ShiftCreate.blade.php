<?php
    $jarFilePath = "java -Dfile.encoding=UTF-8 -jar /data/sotuken-test/Sotu.jar";
    //$cmd = escapeshellcmd($jarFilePath);
    $array = array();
    shell_exec($jarFilePath);
    

    if($array){
        print_r($array);
    }
    elseif($array == false){
        echo "NG";
    }

    // $path = "java -jar Sotu.jar";
    // $cmd2 = escapeshellcmd($path);
    // echo $result2 = exec($cmd,$output2,$error2);

    // if($result2){
    //     echo $result2;
    // }
    // elseif($result2 == false){
    //     echo "NG";
    // }


?>