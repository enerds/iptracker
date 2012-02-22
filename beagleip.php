<?php

// attempt to create table,
// if it exists, it simply fails without consequences
$qry = "CREATE TABLE ips(Id integer PRIMARY KEY, " .
  "IP text NOT NULL, ".
  "DATE text NOT NULL)";
$ok = sqlite_exec($dbh, $qry, $error);


if($_GET["ip"])
{
  $dbh = sqlite_open('beagleip.sqlite', 0666, $error);
  if(!$dbh) die ($error);

  // write to sqlite db
  $qry = "INSERT INTO ips (Id, IP, DATE) 
    VALUES 
    (NULL, '".mysql_real_escape_string($_GET["ip"])."', '".exec(date)."')";
  $ok = sqlite_exec($dbh, $qry, $error);
  if(!$ok) echo "Error: ".$error;
  sqlite_close($dbh);
}
else
{
  echo '<small>Aktuelle Serverzeit: '.exec(date).' </small><br /><br />';
  $dbh = sqlite_open('beagleip.sqlite', 0666, $error);
  if(!$dbh) die ($error);

  $first_switch = true;

  $qry = "SELECT * FROM ips ORDER BY Id DESC LIMIT 20";
  if($res = sqlite_query($dbh,$qry)){
    while($row = sqlite_fetch_array($res, SQLITE_ASSOC))
      {
      if($first_switch) echo '<a href="http://'.$row['IP'].'" target="_blank" />';
      echo $row['Id'].' - '.$row['DATE'].' - '.$row['IP'].'<br />';
      if($first_switch)
      {
        echo '</a>';
        $first_switch = false;
      }
    }
  }
  sqlite_close($dbh);
}
?>
