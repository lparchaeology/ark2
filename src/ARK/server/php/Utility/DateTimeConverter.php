<?php

/**
 * ARK Date Time Utilities.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Utility;

use IntlDateFormatter;

class DateTimeConverter
{
    private static $icuToPicker = [
        'dd-MM-yyyy' => 'dd-mm-yyyy',
        'yyyy-MM-dd' => 'yyyy-mm-dd',
    ];

    public static function typeFormatter(string $locale, int $type, string $datatype = 'datetime') : IntlDateFormatter
    {
        $datetype = ($datatype === 'time' ? IntlDateFormatter::NONE : $type);
        $timetype = ($datatype === 'date' ? IntlDateFormatter::NONE : $type);
        return new IntlDateFormatter($locale, $datetype, $timetype);
    }

    public static function patternFormatter(string $locale, string $pattern, string $datatype = 'datetime') : IntlDateFormatter
    {
        $intl = self::typeFormatter($locale, IntlDateFormatter::FULL, $datatype);
        $intl->setPattern($pattern);
        return $intl;
    }

    public static function formatter(string $locale, $format, string $datatype = 'datetime') : IntlDateFormatter
    {
        if (is_int($format)) {
            return self::typeFormatter($locale, $format, $datatype);
        }
        return self::patternFormatter($locale, $format, $datatype);
    }

    public static function format($value, string $locale, $format, string $datatype = 'datetime') : ?string
    {
        $intl = self::formatter($locale, $format, $datatype);
        return $intl->format($value);
    }

    public static function patternToFormat($pattern)
    {
        switch ($pattern) {
            case 'full':
                return IntlDateFormatter::FULL;
            case 'long':
                return IntlDateFormatter::LONG;
            case 'medium':
                return IntlDateFormatter::MEDIUM;
            case 'short':
                return IntlDateFormatter::SHORT;
            default:
                return $pattern;
        }
    }

    public static function typeToPattern(string $locale, int $type, string $datatype = 'datetime') : ?string
    {
        $intl = self::formatter($locale, $type, $datatype);
        return $intl->getPattern();
    }

    public static function formatToPickerFormat(string $locale, $format, string $datatype = 'datetime') : string
    {
        if (is_int($format)) {
            $pattern = self::typeToPattern($locale, $format, $datatype);
        } else {
            $pattern = $format;
        }
        if (isset(self::$icuToPicker[$pattern])) {
            return self::$icuToPicker[$pattern];
        }
        $picker = str_replace('a', 'p', $pattern);
        $picker = str_replace('m', 'i', $picker);
        if (mb_strpos($picker, 'H') !== false) {
            $picker = str_replace('H', 'h', $picker);
        } elseif (mb_strpos($picker, 'h') !== false) {
            $picker = str_replace('h', 'H', $picker);
        }
        if (mb_strpos($picker, 'MMMM') !== false) {
            $picker = str_replace('MMMM', 'MM', $picker);
        } elseif (mb_strpos($picker, 'MMM') !== false) {
            $picker = str_replace('MMM', 'M', $picker);
        } elseif (mb_strpos($picker, 'M') !== false) {
            $picker = str_replace('M', 'm', $picker);
        }
        return $picker;
    }
}
