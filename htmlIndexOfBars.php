#!/usr/bin/php -q
<?

if ( isset($_SERVER['argv'][1]) && is_dir($_SERVER['argv'][1]) ) {
	$directory=$_SERVER['argv'][1];
} else {
	die("specify directory\n");
}


$dir=opendir($directory);

$imageFiles=array();

while ( $f=readdir($dir) ) {
	if ( strlen($f) > 4 && 'png' == substr($f,strlen($f)-3) ) {
		$imageFiles[]=$f;
	} else if ( strlen($f) > 4 && 'csv' == substr($f,strlen($f)-3) ) {
		$dataFile=$f;
	}

}

sort($imageFiles);



closedir($dir);


?>
<html>
<?
for ( $i=0 ; $i<count($imageFiles) ; $i++ ) {
	printf("\t<img src=\"%s\" /><br />\n",$imageFiles[$i]);

}
?>
<a href="<? echo $dataFile; ?>">Daily energy production data (CSV)</a>
</html>
