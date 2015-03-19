energyScenario.php table samplesPerHour year powerCurve

example: 
./energyScenario.php selawik 0.04166666666666666667 2014 2 > selawik.WT14.result
selawik is the table name
0.04166666666666666667 corresponds to 1 sample every 24 hours
2014 is the year we want to analyze
2 is the APRS World WT14 power curve


energyBar.php resultFile maxKWHonYAxis

example:
./energyBar.php selawik.WT14.result 10
selawik.WT14.result is the result file from energyScenario.php
10 means that 10 kWh is the maximum value of the y-axis (daily energy production)



MySQL table format:

mysql> describe selawik;
+-------------+----------+------+-----+---------+-------+
| Field       | Type     | Null | Key | Default | Extra |
+-------------+----------+------+-----+---------+-------+
| packet_date | datetime | NO   | PRI | NULL    |       |
| windspeedMS | float    | NO   |     | NULL    |       |
+-------------+----------+------+-----+---------+-------+
2 rows in set (0.00 sec)

mysql>
