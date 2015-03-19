#!/usr/bin/php -q
<?
/* Year if format YYYY, Day in year 1 to 366 */
function dayofyear2date( $year, $DayInYear, $hours, $minutes ) {
	$d = new DateTime($year.'-01-01');
	date_modify($d, '+'.($DayInYear-1).' days');

	if ( 0 != $hours ) {
		date_modify($d, '+' . $hours . ' hours');
	}

	if ( 0 != $minutes ) {
		date_modify($d, '+' . $minutes . ' minutes');
	}

	return ($d);
}

$fp=fopen("deadhorseWS.csv","r");

/*
Array
(
    [0] => Year
    [1] => DOY
    [2] => HHMM
    [3] => WindSpeed (m/s)
    [4] => WindDir (deg)
    [5] => WindSpeedStdev (m/s)
    [6] => Tair1 (degC)
    [7] => Tair2 (degC)
    [8] => PARin (w/m2)
    [9] => PARout (w/m2)
    [10] => Battery (V)
)
*/
/* swallow header */
fgets($fp);

while ( $r=fgetcsv($fp) ) {
//	print_r($r);


	$hours=$r[2]/100;
	/* minutes are last two characters of $r[2] */
	$minutes=substr($r[2],strlen($r[2])-2);
	/* hours are strlen($r[2])-strlen($minutes) starting from 0 */
	$hours=substr($r[2],0,strlen($r[2])-strlen($minutes));
//	printf("[2]=%s hours=%s minutes=%s\n",$r[2],$hours,$minutes);

	$date=dayofyear2date($r[0],$r[1],$hours,$minutes);
	$sDate=$date->format('Y-m-d H:i:s');
//	printf("%s (from %s %s)\n",$sDate,$r[0],$r[1]);

	printf("REPLACE INTO deadhorse VALUES('%s', %s);\n",$sDate,$r[3]);

}
/*
Array
(
    [0] => 2013
    [1] => 270
    [2] => 30
    [3] => 1.056
    [4] => 93.4
    [5] => 24.88
    [6] => -3.027
    [7] => -2.937
    [8] => 309
    [9] => 270.9
    [10] => 13.8
)
*/


fclose($fp);

?>
