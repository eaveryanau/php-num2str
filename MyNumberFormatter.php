<?php

/**
 * Class MyNumberFormatter
 * Wrapper class for solving the problem of converting a number to a string
 */
class MyNumberFormatter
{
    //You can change to comma etc.
    const CENTS_DELIMITER = '.';

    const VOCABULARY = [
        0 => 'null',
        1 => 'one',
        2 => 'two',
        3 => 'tree',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
    ];

    const VOC_CAT = [
        0 => '',
        1 => ' thousand ',      // 1 000
        2 => ' million ',       // 1 000 000
        3 => ' billion ',       // 1 000 000 000
        4 => ' trillion ',      // 1 000 000 000 000
        5 => ' quadrillion ',   // 1 000 000 000 000 000
        6 => ' quintillion ',   // 1 000 000 000 000 000 000
        7 => ' sextillion ',    // 1 000 000 000 000 000 000 000
        8 => ' septillion ',    // 1 000 000 000 000 000 000 000 000
        9 => ' octillion ',     // 1 000 000 000 000 000 000 000 000 000
        10 => ' nonillion '      // 1 000 000 000 000 000 000 000 000 000 000
    ];

    const HUNDRED = ' hundred';
    const CENTS = ' cents';
    const CENT = ' cent';

    const OUT_DELIMITER = "\r\n==================\r\n";
    const ERROR_MESSAGE = 'Incorrect input';

    /**
     * @param $number
     * @return string
     */
    public static function num2Text($number): string
    {
        $result = $number;
        $cents = null;

        $explodeNumber = explode(self::CENTS_DELIMITER, $number);

        // Parse cents
        $outCents = '';
        if (isset($explodeNumber[1])) {
            $cents = $explodeNumber[1];

            $outCents .= ' and '.self::numberLessThanThousand2Text($cents);

            $outCents .= ($cents > 1) ? self::CENTS : self::CENT;
        }
        $number = self::trimFormatString($explodeNumber[0]);

        // Check for incorrect input
        if (!is_numeric($number)) {
            return $result.self::OUT_DELIMITER.self::ERROR_MESSAGE.self::OUT_DELIMITER;
        }

        // 1 234 => 001 234
        if (strlen($number) % 3 != 0) {
            $number = str_pad($number, strlen($number) + (3 - strlen($number) % 3), '0', STR_PAD_LEFT);
        }

        $arr = array_reverse(str_split($number, 3));

        $tempArr = [];
        $count = 0;
        foreach ($arr as $num) {
            $tempArr [$count] = self::numberLessThanThousand2Text(intval($num));
            $count++;
        }
        $tempArr = array_reverse($tempArr, true);
        $result .= self::OUT_DELIMITER;
        foreach ($tempArr as $key => $value) {
            if ($value === '') {
                continue;
            }
            $result .= $value.self::VOC_CAT[$key];
        }
        $result .= $outCents;
        $result .= self::OUT_DELIMITER;

        return $result;
    }

    /**
     * @param int $number
     * @return string
     */
    public static function numberLessThanThousand2Text(int $number): string
    {
        $outCents = '';
        $number = intval($number);

        if ($number == 0) {
            return '';
        }

        $countOfHundred = intval($number / 100);
        if ($countOfHundred > 0) {
            $outCents .= self::VOCABULARY[$countOfHundred].self::HUNDRED;
            $number = $number % 100;
        }

        if ($number == 0) {
            return trim($outCents);
        }

        // Less than 20 numbers are defined in the dictionary
        if ($number > 20) {
            $remainderOfDivision = $number % 10;
            $outCents .= ' '.self::VOCABULARY[$number - $remainderOfDivision];
            if ($remainderOfDivision > 0) {
                $outCents .= ' '.self::VOCABULARY[$remainderOfDivision];
            }
        } else {
            $outCents .= ' '.self::VOCABULARY[$number];
        }

        return trim($outCents);
    }

    /**
     * @param string $number
     * @return string|
     */
    public static function trimFormatString($number)
    {
        $number = preg_replace('/[ ,]/', '', $number);

        return $number;
    }
}