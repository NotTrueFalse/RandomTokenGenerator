<?php
function add_letters($string,$letters){
    $string=str_split($string);
    $letters=str_split($letters);
    $string=array_merge($string,$letters);
    shuffle($string);
    $string=implode("",$string);
    return $string;
}

function generateRandomToken($length = 56,$prefix="") {
    $token = bin2hex(random_bytes($length));
    $iterations = rand(2,5);
    $algos = ["sha256", "sha512", "sha384","sha3-256","sha3-384","sha3-512"];
    for ($i = 0; $i < $iterations; $i++) {
        $hashAlgo = $algos[rand(0, count($algos) - 1)];
        $token = hash($hashAlgo, $token);
    }
    $token = hash("sha3-224", $token);
    $token=add_letters($token,"ghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0");
    $token=$token;
    //remove 1 letter at then end then shuffle, then repeat the process until the length is correct
    while(strlen($token)>$length){
        $token=str_split($token);
        array_pop($token);
        shuffle($token);
        $token=implode("",$token);
    }
    $token=$prefix.$token;
    if(strlen($token)!=$length){
        $token=substr($token,0,$length);
    }
    return $token;
}
echo "<pre>".generateRandomToken(56,isset($_GET["token"])?$_GET["token"]:"")."</pre>";
?>
