<?php

/**
 * Class Dotty
 *
 * A simple class to get a value, or values, from an array, or many arrays, using dot notation.
 *
 */
class Dotty
{

    /**
     * Use dot notation to access a value from an array.
     *
     * @param string $value Dot notation accessor
     * @param array $record Array of values to search
     * @return string
     */
    public static function getValue($value, array $record)
    {
        foreach (explode('.', $value) as $section) {
            $record = &$record[$section];
        }
        return $record;
    }

    /**
     * Pass in many dot notation values to retrieve from an array.
     *
     * @param array $arrayOfValues Array of dot notation values, key will be preserved.
     * @param array $record Array of values to search
     * @return array Array of found values
     */
    public static function getValues(array $arrayOfValues, array $record)
    {
        $newRecord = [];
        foreach ($arrayOfValues as $name => $value) {
            $newRecord[$name] = self::getValue($value, $record);
        }
        return $newRecord;
    }

    /**
     * Pass in many dot notation values to retrieve from multiple arrays.
     *
     * @param array $arrayOfValues Array of dot notation values, key will be preserved.
     * @param array $arrayOfRecords Multiple arrays of values to search
     * @return array Multiple arrays of found values
     */
    public static function getValuesMultiple(array $arrayOfValues, array $arrayOfRecords)
    {
        $returnArray = [];
        foreach ($arrayOfRecords as $record) {
            $returnArray[] = self::getValues($arrayOfValues, $record);
        }
        return $returnArray;
    }
}