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

$fp=fopen("KingSalmonPri2012to2013_WindData.csv","r");

/*
[0] => YEAR
[1] => JULIAN_DAY
[2] => ZTIME
[3] => LATITUDE
[4] => LONGITUDE
[5] => WindSp20ft
*/
/* swallow header */
fgetcsv($fp);
fgetcsv($fp);
fgetcsv($fp);

while ( $r=fgetcsv($fp) ) {
//	print_r($r);


	/* minutes are last five characters of $r[2] */
	$minutes=substr($r[2],strlen($r[2])-5);
	/* hours are strlen($r[2])-strlen($minutes) starting from 0 */
	$hours=substr($r[2],0,strlen($r[2])-strlen($minutes));
//	printf("[2]=%s hours=%s minutes=%s\n",$r[2],$hours,$minutes);

	$date=dayofyear2date((int) $r[0],$r[1],$hours,$minutes);
	$sDate=$date->format('Y-m-d H:i:s');
//	printf("%s (from %s %s)\n",$sDate,$r[0],$r[1]);

	/* $r[5] is some sort of wind speed in m/s */
	printf("REPLACE INTO kingsalmon VALUES('%s', %s);\n",$sDate,$r[5]);

}
/*
[0] => 2012.00
[1] => 230.00
[2] => 2100.00
[3] => 58.21
[4] => -155.92
[5] => 3.20 (m/s)
*/


fclose($fp);

?>
