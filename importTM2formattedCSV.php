#!/usr/local/bin/php -q
<?
/* 
 UTCDate   UTCTime   Location  WindDir  WindSpdKTS  Temp1C  Temp2C  RH1%  RH2%  SolarWM2  Pres1MB  Pres2MB  Pres3MB
 01/01/13  00:01:00  CAIR      100      05.4        -25.8   -26.3   63    66    461       691.2    691.2    691.2
012345678901234567890123456789012345678901234567890123456789
          1         2         3         4         5

0	Year
1	Month
2	Day
3	Hour
4	Extraterrestrial Horizontal Radiation [Wh/m^2]
5	Extraterrestrial Direct Normal Radiation [Wh/m^2]
6	Global Horizontal Radiation [Wh/m^2]
7	Flag for Data Source
8	Flag for Data Uncertainty
9	Direct normal Radiation [Wh/m^2]
10	Flag for Data Source
11	Flag for Data Uncertainty
12	Diffuse Horizontal Radiation [Wh/m^2]
13	Flag for Data Source
14	Flag for Data Uncertainty
15	Global Horizontal Illuminance
16	Flag for Data Source
17	Flag for Data Uncertainty
18	Direct Normal Illuminance
19	Flag for Data Source
20	Flag for Data Uncertainty
21	Diffuse Horizontal Illuminance
22	Flag for Data Source
23	Flag for Data Uncertainty
24	Zenith Luminance
25	Flag for Data Source
26	Flag for Data Uncertainty
27	Total Sky Cover
28	Flag for Data Source
29	Flag for Data Uncertainty
30	Opaque Sky Cover
31	Flag for Data Source
32	Flag for Data Uncertainty
33	Dry Bulb Temperature [1/10 °C]
34	Flag for Data Source
35	Flag for Data Uncertainty
36	Dew Point Temperature [1/10 °C]
37	Flag for Data Source
38	Flag for Data Uncertainty
39	Relative humidity [%]
40	Flag for Data Source
41	Flag for Data Uncertainty
42	Atmospheric pressure [mBar]
43	Flag for Data Source
44	Flag for Data Uncertainty
45	"Wind direction [°] ( N=0,	E=90)"
46	Flag for Data Source
47	Flag for Data Uncertainty
48	Wind speed [tenths m/s]
49	Flag for Data Source
50	Flag for Data Uncertainty
51	Visibility [tenths km]
52	Flag for Data Source
53	Flag for Data Uncertainty
54	Ceiling height [m]
55	Flag for Data Source
56	Flag for Data Uncertainty
57	Present Weather
58	Precipitable Water [mm]
59	Flag for Data Source
60	Flag for Data Uncertainty
61	Aerosol Optical Depth [1/1000]
62	Flag for Data Source
63	Flag for Data Uncertainty
64	Snow Depth [cm]
65	Flag for Data Source
66	Flag for Data Uncertainty
67	Days Since Last Snowfall
68	Flag for Data Source
69	Flag for Data Uncertainty

95,1,1,1,0,0,0,?,4,0,?,4,0,?,4,0,I,4,0,I,4,0,I,4,9999,?,0,5,E,7,2,E,7,-194,E,7,-307,E,7,35,E,7,1005,E,7,173,E,7,39,E,7,9999,?,0,99999,?,0,99999999?0,1,E,7,999,?,0,999,?,0,99,?,0
*/

$fp=fopen($_SERVER['argv'][1],'r');

while ( $r=fgetcsv($fp,1024) ) {
	if ( ! is_numeric(substr($r[0],1,1)) ) 
		continue;


	$month=$r[1];
	$day=$r[2];
	$year=1900 + $r[0];

	$hour=$r[3];
	$minute=0;
	$second=0;

	$windSpeedMS=$r[48]/10.0;

	$values=sprintf("'%04d-%02d-%02d %02d:%02d:%02d', %0.1f",$year,$month,$day,$hour,$minute,$second,$windSpeedMS);

	printf("INSERT IGNORE INTO %s VALUES (%s);\n",$_SERVER['argv'][2],$values);
}

?>
