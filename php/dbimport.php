<?php
$host = 'localhost';
	$usernam = 'root';
	$password = 'toor';
	$dbName = 'mlcl';

$connecton=mysql_connect($host,$usernam,$password);
$con=mysql_select_db($dbName,$connecton) or die("Error Connecting to the database. Access Denied");
$query=mysql_query("SELECT t.cat_parents,t.cat_name, s.p_name, s.p_created, s.p_image, s.p_price FROM tbl_products s, tbl_category t WHERE s.p_category=t.cat_id and t.cat_parents=1");
while($row=mysql_fetch_array($query))
{
	switch($row[0])
	{
		case 1:$parent='Boys/';break;
		case 2:$parent='Girls/';break;
		case 3:$parent='Neutral/';break;
		case 4:$parent="Holidays/";break;
	}
	//echo $parent . $row[1] . " <br/>";
	$url=strtolower(str_replace(" ","-",$row[2]));
	echo "$parent$row[1]<br/>";
	//echo " $parent$row[1] . <font color='red'>".$row[3]. "</font> <font color='blue'>$row[4]</font> <font color='green'>$row[2]</font> \$$row[5] <font color='red'>$url</font> <font color='blue'>$url.html</font><br/>";
}
?>
