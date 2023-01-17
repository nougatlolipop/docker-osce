<?php
function rv($rules, $error)
{
    return [
        'rules' => $rules,
        'errors' => $error
    ];
}

function getRandomHex($num_bytes = 4)
{
    return strtoupper(bin2hex(random_bytes($num_bytes)));
}

function ceknull($string)
{
    return trim(html_entity_decode(str_replace('&nbsp;', '', $string)));
}

function susunpeserta($arr, $mulai)
{
    $people = $arr;
    $station = count($people);

    $result = [];
    if ($mulai < 2) {
        $arrayStart = array_slice($people, 0, 1);
        $arrayEnd = array_slice($people, 1, $station - 1);
        $arr = array_merge($arrayStart, array_reverse($arrayEnd));

        foreach ($arr as $key => $value) {
            $result[] = [
                'urutan' => $key + 1,
                'mahasiswa' => $value,
                "kehadiran" => 1
            ];
        }
        return $result;
    }

    if ($station == $mulai) {
        $arr = array_reverse($arr);
        foreach ($arr as $key => $value) {
            $result[] = [
                'urutan' => $key + 1,
                'mahasiswa' => $value,
                "kehadiran" => 1
            ];
        }
        return $result;
    }

    $start = $mulai;
    $arrayStart = array_slice($people, 0, $start);
    $arrayEnd = array_slice($people, $start, $station - 1);

    $arr = array_merge(array_reverse($arrayStart), array_reverse($arrayEnd));
    foreach ($arr as $key => $value) {
        $result[] = [
            'urutan' => $key + 1,
            'mahasiswa' => $value,
            "kehadiran" => 1
        ];
    }
    return $result;
}
