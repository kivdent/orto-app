<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\userInterface\helpers;

/**
 * Description of FormatHelper
 *
 * @author kivde
 */
class FormatHelper {

    const DAY_OF_WEEK = [
        '1' => 'Понедельник',
        '2' => 'Вторник',
        '3' => 'Среда',
        '4' => 'Четверг',
        '5' => 'Пятница',
        '6' => 'Суббота',
        '7' => 'Воскресенье',
    ];

    public static function getNameDayWeek($numberDayWeek) {
        return self::DAY_OF_WEEK[$numberDayWeek];
    }

}
