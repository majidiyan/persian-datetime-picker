<?php

namespace Magentoyan\FarsiAdmin\Model;

class Jalali
{
    //jalali methods majidian

    public function jdate($type, $maket="now") {
        //set 1 if you want translate number to farsi or if you don't like set 0
        $transnumber = 0;
        ///chosse your timezone
        $TZhours = 0;
        $TZminute = 0;
        $need = "";
        $result1 = "";
        $result = "";
        if ($maket == "now") {
            $year = date("Y");
            $month = date("m");
            $day = date("d");
            list( $jyear, $jmonth, $jday ) = $this->gregorianToJalali($year, $month, $day);
            $maket = mktime(date("H") + $TZhours, date("i") + $TZminute, date("s"), date("m"), date("d"), date("Y"));
        } else {
            //$maket=0;
            $maket+=$TZhours * 3600 + $TZminute * 60;
            $date = date("Y-m-d", $maket);
            list( $year, $month, $day ) = preg_split('/-/', $date);

            list( $jyear, $jmonth, $jday ) = $this->gregorianToJalali($year, $month, $day);
        }

        $need = $maket;
        $year = date("Y", $need);
        $month = date("m", $need);
        $day = date("d", $need);
        $i = 0;
        $subtype = "";
        $subtypetemp = "";
        list( $jyear, $jmonth, $jday ) = $this->gregorianToJalali($year, $month, $day);
        while ($i < strlen($type)) {
            $subtype = substr($type, $i, 1);
            if ($subtypetemp == "\\") {
                $result.=$subtype;
                $i++;
                continue;
            }

            switch ($subtype) {

                case "A":
                    $result1 = date("a", $need);
                    if ($result1 == "pm")
                        $result.= "&#1576;&#1593;&#1583;&#1575;&#1586;&#1592;&#1607;&#1585;";
                    else
                        $result.="&#1602;&#1576;&#1604;&#8207;&#1575;&#1586;&#1592;&#1607;&#1585;";
                    break;

                case "a":
                    $result1 = date("a", $need);
                    if ($result1 == "pm")
                        $result.= "&#1576;&#46;&#1592;";
                    else
                        $result.="&#1602;&#46;&#1592;";
                    break;
                case "d":
                    if ($jday < 10)
                        $result1 = "0" . $jday;
                    else
                        $result1=$jday;
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "D":
                    $result1 = date("D", $need);
                    if ($result1 == "Thu")
                        $result1 = "&#1662;";
                    else if ($result1 == "Sat")
                        $result1 = "&#1588;";
                    else if ($result1 == "Sun")
                        $result1 = "&#1609;";
                    else if ($result1 == "Mon")
                        $result1 = "&#1583;";
                    else if ($result1 == "Tue")
                        $result1 = "&#1587;";
                    else if ($result1 == "Wed")
                        $result1 = "&#1670;";
                    else if ($result1 == "Thu")
                        $result1 = "&#1662;";
                    else if ($result1 == "Fri")
                        $result1 = "&#1580;";
                    $result.=$result1;
                    break;
                case"F":
                    $result.=$this->monthname($jmonth);
                    break;
                case "g":
                    $result1 = date("g", $need);
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "G":
                    $result1 = date("G", $need);
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "h":
                    $result1 = date("h", $need);
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "H":
                    $result1 = date("H", $need);
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "i":
                    $result1 = date("i", $need);
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "j":
                    $result1 = $jday;
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "l":
                    $result1 = date("l", $need);
                    if ($result1 == "Saturday")
                        $result1 = "&#1588;&#1606;&#1576;&#1607;";
                    else if ($result1 == "Sunday")
                        $result1 = "&#1610;&#1705;&#1588;&#1606;&#1576;&#1607;";
                    else if ($result1 == "Monday")
                        $result1 = "&#1583;&#1608;&#1588;&#1606;&#1576;&#1607;";
                    else if ($result1 == "Tuesday")
                        $result1 = "&#1587;&#1607; &#1588;&#1606;&#1576;&#1607;";
                    else if ($result1 == "Wednesday")
                        $result1 = "&#1670;&#1607;&#1575;&#1585;&#1588;&#1606;&#1576;&#1607;";
                    else if ($result1 == "Thursday")
                        $result1 = "&#1662;&#1606;&#1580;&#1588;&#1606;&#1576;&#1607;";
                    else if ($result1 == "Friday")
                        $result1 = "&#1580;&#1605;&#1593;&#1607;";
                    $result.=$result1;
                    break;
                case "m":
                    if ($jmonth < 10)
                        $result1 = "0" . $jmonth;
                    else
                        $result1=$jmonth;
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "M":
                    $result.=$this->shortMonthname($jmonth);
                    break;
                case "n":
                    $result1 = $jmonth;
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "s":
                    $result1 = date("s", $need);
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "S":
                    $result.="";
                    break;
                case "t":
                    $result.=$this->lastday($month, $day, $year);
                    break;
                case "w":
                    $result1 = date("w", $need);
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "y":
                    $result1 = substr($jyear, 2, 4);
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "Y":
                    $result1 = $jyear;
                    if ($transnumber == 1)
                        $result.=$this->convertNumberToFarsi($result1);
                    else
                        $result.=$result1;
                    break;
                case "U" :
                    $result.=mktime();
                    break;
                case "Z" :
                    $result.=$this->daysOfYear($jmonth, $jday, $jyear);
                    break;
                case "L" :
                    list( $tmp_year, $tmp_month, $tmp_day ) = $this->jalaliToGregorian(1384, 12, 1);
                    echo $tmp_day;
                    /* if($this->lastday($tmp_month,$tmp_day,$tmp_year)=="31")
                      $result.="1";
                      else
                      $result.="0";
                     */
                    break;
                default:
                    $result.=$subtype;
            }
            $subtypetemp = substr($type, $i, 1);
            $i++;
        }
        return $result;
    }

    public function jmaketime($hour="", $minute="", $second="", $jmonth="", $jday="", $jyear="") {
        if (!$hour && !$minute && !$second && !$jmonth && !$jmonth && !$jday && !$jyear)
            return mktime();
        list( $year, $month, $day ) = $this->jalaliToGregorian($jyear, $jmonth, $jday);
        $i = mktime($hour, $minute, $second, $month, $day, $year);
        return $i;
    }

///Find num of Day Begining Of Month ( 0 for Sat & 6 for Sun)
    public function mstart($month, $day, $year) {
        list( $jyear, $jmonth, $jday ) = $this->gregorianToJalali($year, $month, $day);
        list( $year, $month, $day ) = $this->jalaliToGregorian($jyear, $jmonth, "1");
        $timestamp = mktime(0, 0, 0, $month, $day, $year);
        return date("w", $timestamp);
    }

//Find Number Of Days In This Month
    public function lastday($month, $day, $year) {
        $jday2 = "";
        $this->jdate2 = "";
        $this->lastdayen = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
        list( $jyear, $jmonth, $jday ) = $this->gregorianToJalali($year, $month, $day);
        $lastdatep = $jday;
        $jday = $jday2;
        while ($jday2 != "1") {
            if ($day < $this->lastdayen) {
                $day++;
                list( $jyear, $jmonth, $jday2 ) = $this->gregorianToJalali($year, $month, $day);
                if ($this->jdate2 == "1")
                    break;
                if ($this->jdate2 != "1")
                    $lastdatep++;
            }
            else {
                $day = 0;
                $month++;
                if ($month == 13) {
                    $month = "1";
                    $year++;
                }
            }
        }
        return $lastdatep - 1;
    }

//Find days in this year untile now 
    public function daysOfYear($jmonth, $jday, $jyear) {
        $year = "";
        $month = "";
        $year = "";
        $result = "";
        if ($jmonth == "01")
            return $jday;
        for ($i = 1; $i < $jmonth || $i == 12; $i++) {
            list( $year, $month, $day ) = $this->jalaliToGregorian($jyear, $i, "1");
            $result+=$this->lastday($month, $day, $year);
        }
        return $result + $jday;
    }

//translate number of month to name of month
    public function monthname($month) {

        if ($month == "01")
            return "&#1601;&#1585;&#1608;&#1585;&#1583;&#1610;&#1606;";

        if ($month == "02")
            return "&#1575;&#1585;&#1583;&#1610;&#1576;&#1607;&#1588;&#1578;";

        if ($month == "03")
            return "&#1582;&#1585;&#1583;&#1575;&#1583;";

        if ($month == "04")
            return "&#1578;&#1610;&#1585;";

        if ($month == "05")
            return "&#1605;&#1585;&#1583;&#1575;&#1583;";

        if ($month == "06")
            return "&#1588;&#1607;&#1585;&#1610;&#1608;&#1585;";

        if ($month == "07")
            return "&#1605;&#1607;&#1585;";

        if ($month == "08")
            return "&#1570;&#1576;&#1575;&#1606;";

        if ($month == "09")
            return "&#1570;&#1584;&#1585;";

        if ($month == "10")
            return "&#1583;&#1610;";

        if ($month == "11")
            return "&#1576;&#1607;&#1605;&#1606;";

        if ($month == "12")
            return "&#1575;&#1587;&#1601;&#1606;&#1583;";
    }

    public function shortMonthname($month) {

        if ($month == "01")
            return "&#1601;&#1585;&#1608;";

        if ($month == "02")
            return "&#1575;&#1585;&#1583;";

        if ($month == "03")
            return "&#1582;&#1585;&#1583;";

        if ($month == "04")
            return "&#1578;&#1610;&#1585;";

        if ($month == "05")
            return "&#1605;&#1585;&#1583;";

        if ($month == "06")
            return "&#1588;&#1607;&#1585;";

        if ($month == "07")
            return "&#1605;&#1607;&#1585;";

        if ($month == "08")
            return "&#1570;&#1576;&#1575;";

        if ($month == "09")
            return "&#1570;&#1584;&#1585;";

        if ($month == "10")
            return "&#1583;&#1610;";

        if ($month == "11")
            return "&#1576;&#1607;&#1605;";

        if ($month == "12")
            return "&#1575;&#1587;&#1601; ";
    }

////here convert to  number in persian
    public function convertNumberToFarsi($srting) {
        $num0 = "&#1776;";
        $num1 = "&#1777;";
        $num2 = "&#1778;";
        $num3 = "&#1779;";
        $num4 = "&#1780;";
        $num5 = "&#1781;";
        $num6 = "&#1782;";
        $num7 = "&#1783;";
        $num8 = "&#1784;";
        $num9 = "&#1785;";

        $stringtemp = "";
        $len = strlen($srting);
        for ($sub = 0; $sub < $len; $sub++) {
            if (substr($srting, $sub, 1) == "0")
                $stringtemp.=$num0;
            elseif (substr($srting, $sub, 1) == "1")
                $stringtemp.=$num1;
            elseif (substr($srting, $sub, 1) == "2")
                $stringtemp.=$num2;
            elseif (substr($srting, $sub, 1) == "3")
                $stringtemp.=$num3;
            elseif (substr($srting, $sub, 1) == "4")
                $stringtemp.=$num4;
            elseif (substr($srting, $sub, 1) == "5")
                $stringtemp.=$num5;
            elseif (substr($srting, $sub, 1) == "6")
                $stringtemp.=$num6;
            elseif (substr($srting, $sub, 1) == "7")
                $stringtemp.=$num7;
            elseif (substr($srting, $sub, 1) == "8")
                $stringtemp.=$num8;
            elseif (substr($srting, $sub, 1) == "9")
                $stringtemp.=$num9;
            else
                $stringtemp.=substr($srting, $sub, 1);
        }
        return $stringtemp;
    }

///end conver to number in persian

    public function isKabise($year) {
        if ($year % 4 == 0 && $year % 100 != 0)
            return true;
        return false;
    }

    public function jcheckdate($month, $day, $year) {
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
        if ($month <= 12 && $month > 0) {
            if ($j_days_in_month[$month - 1] >= $day && $day > 0)
                return 1;
            if ($this->isKabise($year))
                echo "Asdsd";
            if ($this->isKabise($year) && $j_days_in_month[$month - 1] == 31)
                return 1;
        }

        return 0;
    }

    public function jtime() {
        return mktime();
    }

    public function jgetdate($timestamp="") {
        if ($timestamp == "")
            $timestamp = mktime();

        return array(
            0 => $timestamp,
            "seconds" => $this->jdate("s", $timestamp),
            "minutes" => $this->jdate("i", $timestamp),
            "hours" => $this->jdate("G", $timestamp),
            "mday" => $this->jdate("j", $timestamp),
            "wday" => $this->jdate("w", $timestamp),
            "mon" => $this->jdate("n", $timestamp),
            "year" => $this->jdate("Y", $timestamp),
            "yday" => $this->daysOfYear($this->jdate("m", $timestamp), $this->jdate("d", $timestamp), $this->jdate("Y", $timestamp)),
            "weekday" => $this->jdate("l", $timestamp),
            "month" => $this->jdate("F", $timestamp),
        );
    }



    public function div($a, $b) {
        return (int) ($a / $b);
    }

    public function gregorianToJalali($g_y, $g_m, $g_d) {

        $g_y = trim($g_y, ',' );
        $g_m = trim($g_m, ','  );
        $g_d = trim($g_d, ','  );

        try{
            $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
            $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

            $gy = $g_y - 1600;
            $gm = $g_m - 1;
            $gd = $g_d - 1;

            $g_day_no = 365 * $gy + $this->div($gy + 3, 4) - $this->div($gy + 99, 100) + $this->div($gy + 399, 400);

            for ($i = 0; $i < $gm; ++$i)
                $g_day_no += $g_days_in_month[$i];
            if ($gm > 1 && (($gy % 4 == 0 && $gy % 100 != 0) || ($gy % 400 == 0)))
                /* leap and after Feb */
                $g_day_no++;
            $g_day_no += $gd;

            $j_day_no = $g_day_no - 79;

            $j_np = $this->div($j_day_no, 12053); /* 12053 = 365*33 + 32/4 */
            $j_day_no = $j_day_no % 12053;

            $jy = 979 + 33 * $j_np + 4 * $this->div($j_day_no, 1461); /* 1461 = 365*4 + 4/4 */

            $j_day_no %= 1461;

            if ($j_day_no >= 366) {
                $jy += $this->div($j_day_no - 1, 365);
                $j_day_no = ($j_day_no - 1) % 365;
            }

            for ($i = 0; $i < 11 && $j_day_no >= $j_days_in_month[$i]; ++$i)
                $j_day_no -= $j_days_in_month[$i];
            $jm = $i + 1;
            $jd = $j_day_no + 1;

            return array($jy, $jm, $jd);
        }catch (\Exception $e) {
            return array($g_y, $g_m, $g_d);
        }
    }

    public function jalaliToGregorian($j_y, $j_m, $j_d) {
        $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);



        $jy = $j_y - 979;
        $jm = $j_m - 1;
        $jd = $j_d - 1;

        $j_day_no = 365 * $jy + $this->div($jy, 33) * 8 + $this->div($jy % 33 + 3, 4);
        for ($i = 0; $i < $jm; ++$i)
            $j_day_no += $j_days_in_month[$i];

        $j_day_no += $jd;

        $g_day_no = $j_day_no + 79;

        $gy = 1600 + 400 * $this->div($g_day_no, 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
        $g_day_no = $g_day_no % 146097;

        $leap = true;
        if ($g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */ {
            $g_day_no--;
            $gy += 100 * $this->div($g_day_no, 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
            $g_day_no = $g_day_no % 36524;

            if ($g_day_no >= 365)
                $g_day_no++;
            else
                $leap = false;
        }

        $gy += 4 * $this->div($g_day_no, 1461); /* 1461 = 365*4 + 4/4 */
        $g_day_no %= 1461;

        if ($g_day_no >= 366) {
            $leap = false;

            $g_day_no--;
            $gy += $this->div($g_day_no, 365);
            $g_day_no = $g_day_no % 365;
        }

        for ($i = 0; $g_day_no >= $g_days_in_month[$i] + ($i == 1 && $leap); $i++)
            $g_day_no -= $g_days_in_month[$i] + ($i == 1 && $leap);
        $gm = $i + 1;
        $gd = $g_day_no + 1;

        return array($gy, $gm, $gd);
    }

    public function getJalaliNumericDate($gdate='now') {
        return $this->jdate("Y-m-d");
    }

    public function getJalaliAlphabeticDate($gdate='now') {
        return $this->jdate("Y-F-d");
    }

    public function getTime($gdate='now') {
        $time = localtime();
        return ($time[2] + 3) . ":" . ($time[1] + 30) . ":" . $time[0];
    }



    //jalali methods majidian end
}