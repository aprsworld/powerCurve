#!/usr/local/bin/php -q
<?
$pCurves[0]='BWC Excel-R';
$pCurves[1]='APRS WT10';
$pCurves[2]='APRS WT14';
/* BWC Excel-R 7.5kW
index is m/s bin
value is kilowatts output
 */
$powerCurve[0]=array(
	0=>0.00,
	1=>0.00,
	2=>0.00,
	3=>0.00,
	4=>0.22,
	5=>0.70,
	6=>1.45,
	7=>2.24,
	8=>3.20,
	9=>4.26,
	10=>5.40,
	11=>6.58,
	12=>7.02,
	13=>7.02,
	14=>7.02,
	15=>6.14,
	16=>4.39,
	17=>2.37,
	18=>2.63,
	19=>2.63,
	20=>2.63, /* BWC power curve in WindCad ends at this point. Assuming furled and production will remain constant */
	21=>2.63,
	22=>2.63,
	23=>2.63,
	24=>2.63,
	25=>2.63,
	26=>2.63,
	27=>2.63,
	28=>2.63,
	29=>2.63,
	30=>2.63,
	31=>2.63,
	32=>2.63,
	33=>2.63,
	34=>2.63,
	35=>2.63,
	36=>2.63,
	37=>2.63,
	38=>2.63,
	39=>2.63,
	40=>2.63
);

/* APRS World WT10 24 volt charging 24 volt battery
Not an official power curve ... just based on 24 hours of data from before 2014-02-12

SELECT ROUND(windAverageMS0) AS windMS, ROUND(AVG(pRectifier)) AS power FROM view_A3351 WHERE packet_date >= DATE_SUB(now(),INTERVAL 24 HOUR) GROUP BY windMS;

index is m/s bin
value is kilowatts output
 */
$powerCurve[1]=array(
	0=>0.00,
	1=>0.00,
	2=>0.00,
	3=>0.00,
	4=>0.00,
	5=>0.011,
	6=>0.028,
	7=>0.051,
	8=>0.078,
	9=>0.109,
	10=>0.141,
	11=>0.175,
	12=>0.218,
	13=>0.266,
	14=>0.328,
	15=>0.402,
	16=>0.402,
	17=>0.402,
	18=>0.402,
	19=>0.402,
	20=>0.402,
	21=>0.402,
	22=>0.402,
	23=>0.402,
	24=>0.402,
	25=>0.402
);

/* APRS World WT14 72 volt charging 48 volt battery
Not an official power curve ... data from e-mail to Tod Hanley on 2013-03-30

index is m/s bin
value is kilowatts output
 */
$powerCurve[2]=array(
	0=>0.00,
	1=>0.00,
	2=>0.00,
	3=>0.00,
	4=>0.00,
	5=>0.042,
	6=>0.075,
	7=>0.108,
	8=>0.145,
	9=>0.207,
	10=>0.256,
	11=>0.313,
	12=>0.366,
	13=>0.375,
	14=>0.379,
	15=>0.379,
	16=>0.379,
	17=>0.379,
	18=>0.379,
	19=>0.379,
	20=>0.379,
	21=>0.379,
	22=>0.379,
	23=>0.379,
	24=>0.379,
	25=>0.379
);

//print_r($powerCurve);

$startDay=1;
$endDay=366;

$table=$_SERVER['argv'][1];
$samplesPerHour=$_SERVER['argv'][2];
$year=$_SERVER['argv'][3];
$powerCurveToUse=$_SERVER['argv'][4];

$db=mysql_connect("localhost","root","roadtoad");
mysql_select_db("powerCurve");

for ( $day=$startDay ; $day<=$endDay ; $day++ ) {
	$kwhDay=0.0;
	$date='';

	/* get hours per wind speed bin */
	$sql=sprintf("SELECT LEFT(packet_date,10) AS day, ROUND(windspeedMS) AS binMS,COUNT(*)/%s AS hours FROM %s WHERE DAYOFYEAR(packet_date)=%d AND YEAR(packet_date)=%d GROUP BY binMS",$samplesPerHour,$table,$day,$year);

	$q=mysql_query($sql,$db);

	while ( $r=mysql_fetch_array($q,MYSQL_ASSOC) ) {
//		printf("day=%s bin=%s hours=%s\n",$r['day'],$r['binMS'],$r['hours']);

		if ( ! array_key_exists($r['binMS'],$powerCurve[$powerCurveToUse]) ) {
			printf("ERROR: bin for %s does not exist\n",$r['binMS']);
			continue;
		}

		/* energy is powerCurve[binMS] * hours */
		$kwhDay += $powerCurve[$powerCurveToUse][$r['binMS']]*$r['hours'];
		$date=$r['day'];
	}

	if ( '' == $date ) 
		continue;

	printf("%s, %0.2f\n",$date,$kwhDay);
	
	
}




?>
