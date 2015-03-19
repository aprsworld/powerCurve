#!/usr/local/bin/php -q
<?
/* 
 UTCDate   UTCTime   Location  WindDir  WindSpdKTS  Temp1C  Temp2C  RH1%  RH2%  SolarWM2  Pres1MB  Pres2MB  Pres3MB
 01/01/13  00:01:00  CAIR      100      05.4        -25.8   -26.3   63    66    461       691.2    691.2    691.2
012345678901234567890123456789012345678901234567890123456789
          1         2         3         4         5
*/

$fp=fopen($_SERVER['argv'][1],'r');

while ( $line=fgets($fp,256) ) {
	if ( ! is_numeric(substr($line,1,1)) ) 
		continue;


	$month=substr($line,1,2);
	$day=substr($line,4,2);
	$year=2000 + substr($line,7,2);

	$hour=substr($line,11,2);
	$minute=substr($line,14,2);
	$second=substr($line,17,2);

	$windSpeedKTS=substr($line,40,10);

	$values=sprintf("'%04d-%02d-%02d %02d:%02d:%02d', %0.1f",$year,$month,$day,$hour,$minute,$second,$windSpeedKTS*0.514444);

	printf("INSERT IGNORE INTO spole_cair VALUES (%s);\n",$values);
}

?>
