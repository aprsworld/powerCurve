#!/usr/local/bin/php -q
<?


$filename=$_SERVER['argv'][1];
if ( ! file_exists($filename) ) {
	die("Cannot open " . $filename . "\n");
}
$fp=fopen($filename,"r");

if ( isset($_SERVER['argv'][2]) )
	$ymax=$_SERVER['argv'][2];
else
	$ymax=5;

$lastMonth='';
$lastYearMonth='';
$bar=array();
$monthKWH=0.0;
/*
    [0] => 2013-12-29 (date)
    [1] => 5.94 (kWh)
*/
while ( $r=fgetcsv($fp,1024) ) {
	$year=substr($r[0],0,4);
	$month=substr($r[0],5,2);
	$day=substr($r[0],8,2);

	if ( $lastMonth != $month ) {
//		printf("new month detected\n");
		if ( ''==$lastMonth ) {
			$lastMonth=$month;
			
			$monthKWH=0.0;
			continue;
		}

//		printf("bar chart for last month\n");
		/* print the previous months bar chart */
		$barURL=sprintf("http://mybergey.aprsworld.com/data/ps2/bar.php?ymax=%s&title=%s+Energy+Produced&subtitle=%s+kWh+total&xtitle=Day+of+Month&ytitle=kWh&width=800&height=300",$ymax,$lastYearMonth,$monthKWH);

		$barURL .= '&d[]=' . implode("&d[]=",$bar);
		exec( escapeshellcmd(sprintf("wget %s -O %s_%s.png",$barURL,$filename,$lastYearMonth)) ); 


		/* reset statistics for next month */
		$lastMonth=$month;
		$monthKWH=0.0;
		$bar=array();
	}
//	printf("%s-%s-%s\n",$year,$month,$day);

	$monthKWH += $r[1];
	$bar[]=sprintf("%d|%0.1f",$day,$r[1]);
	$lastYearMonth=sprintf("%s-%s",$year,$month);
}
/* print the previous months bar chart */
$barURL=sprintf("http://mybergey.aprsworld.com/data/ps2/bar.php?ymax=%s&title=%s+Energy+Produced&subtitle=%s+kWh+total&xtitle=Day+of+Month&ytitle=kWh&width=800&height=300",$ymax,$lastYearMonth,$monthKWH);

$barURL .= '&d[]=' . implode("&d[]=",$bar);
exec( escapeshellcmd(sprintf("wget %s -O %s_%s.png",$barURL,$filename,$lastYearMonth)) ); 
?>
