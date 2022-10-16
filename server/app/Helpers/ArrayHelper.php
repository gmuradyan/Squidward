<?php

namespace App\Helpers;

class ArrayHelper
{
    public static function sortByKey($multidimensional_array, $key) : array {
        $columns = array_column($multidimensional_array, $key);
        array_multisort($columns, SORT_DESC, $multidimensional_array);

        return $multidimensional_array;
    }
}
