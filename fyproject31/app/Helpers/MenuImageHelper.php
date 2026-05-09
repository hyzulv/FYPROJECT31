<?php

namespace App\Helpers;

class MenuImageHelper
{
    private static $imageMap = [
        'Ayam Goreng Kunyit' => 'ayam-goreng-kunyit.jpg',
        'Daging Goreng Kunyit' => 'Daging-goreng-kunyit.jpg',
        'Sotong Goreng Kunyit' => 'Sotong-goreng-kunyit.jpg',
        'Udang Goreng Kunyit' => 'Udang-goreng-kunyit.jpg',
        'Combo Set Ayam' => 'combo-ayam.jpg',
        'Combo Set Daging' => 'combo-daging.jpg',
        'Combo Set Udang' => 'combo-udang.png',
        'Combo Set Sotong' => 'combo-sotong.jpg',
        'Sotong + Udang Mix' => 'sotong-udang.png',
        'Ayam + Daging Mix' => 'Ayam-daging.png',
        'Ayam + Udang Mix' => 'ayam-udang.png',
        'Ayam + Sotong Mix' => 'ayam-sotong.png',
        'Daging + Sotong Mix' => 'daging-sotong.png',
        'Daging + Udang Mix' => 'daging-udang.png',
        'Nasi Lemak Biasa' => 'nasi-lemak-biasa.jpg',
        'Nasi Lemak Telur Mata' => 'nasi-lemak-telur-mata.jpg',
        'Nasi Lemak Ayam Berempah' => 'nasi-lemak-ayam-berempah.jpg',
        'Nasi Lemak Ayam Kunyit' => 'nasi-lemak-ayam-kunyit.jpg',
        'Nasi Lemak Daging Kunyit' => 'nasi-lemak-daging.png',
        'Nasi Lemak Sotong Kunyit' => 'nasi-lemak-sotong-goreng.jpg',
        'Nasi Lemak Udang Kunyit' => 'nasi-lemak-udang-kunyit.png',
        'Ayam Kicap' => 'ayam-kicap.jpg',
        'Daging Kicap' => 'daging-kicap.png',
        'Set Family' => 'set-family.png',
        'Milo' => 'milo-ais.png',
        'Nescafe' => 'nescafe-ais.jpg',
        'Teh' => 'teh-ais.jpg',
        'Teh O' => 'teh-o.jpg',
        'Air Kosong' => 'ais-kosong.jpg',
    ];

    public static function getImageFilename($itemName)
    {
        return self::$imageMap[$itemName] ?? null;
    }
}
