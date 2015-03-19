#!/usr/bin/php -q
<?

$fp=fopen("akSEL2014.clean.txt","r");
while ( $r=fgets($fp) ) {
	$year=substr($r,7,4);
	$month=substr($r,1,2);
	$day=substr($r,4,2);

	$wsMPH=substr($r,38,10);
	$wsMPH=trim($wsMPH);
	$wsMS=$wsMPH*0.44704;

//	printf("year='%s' month='%s' day='%s' wsMPH='%s' wsMS='%s'\n",$year,$month,$day,$wsMPH,$wsMS);

	/* $r[5] is some sort of wind speed in m/s */
	printf("REPLACE INTO selawik VALUES('%s-%s-%s 00:00:00', %s);\n",$year,$month,$day,$wsMS);

}


fclose($fp);

?>
