<?php include("../system/dbConnection.php");
header('Content-type: text/xml'); ?>




<rss version="2.0">
<feed> <icon>http://merosanokatha.com/img/fav32.pngco</icon></feed>
<channel>

    <title>Mero Sano Katha</title>

    <description>MeroSanoKatha starts with the little stories we make and lessons we learn from all the even and odd experiences of life we go through. We believe, these stories, may be of happiness, sadness, joy or pain have their own importance in our life and surviving them proves us a human. And that makes a story to tell.</description>

    <link>http://merosanokatha.com</link>

<?
if($_GET['limit']) $limit=$_GET['limit']; else $limit=10;
$sql = "SELECT * FROM post where hide=0 order by postid DESC Limit $limit";

$result = mysql_query($sql);

while($row = mysql_fetch_assoc($result)){

?>

 

<item>

     <title><![CDATA[<?=$row['title'];?>]]> </title>

     <description><![CDATA[<?=$row['post'];?>]]></description>

     <link><?=$row['postid']; ?></link>

</item>

 

<?

}

?>

 

</channel>

</rss>
