<?php
try
{
$pdo = new PDO('mysql:host=localhost;dbname=mocie_rating_site', 'tramey','TMRtmr2021');
$pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec ('SET NAMES "utf8"');
}
catch (PDOException $e)
{
echo $e->getMessage ();
exit ();
}
?>
