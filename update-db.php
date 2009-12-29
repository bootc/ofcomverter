<?php
/*
Odds Board
Copyright (C) 2007 Gary Hawkins (gary.hawkins@garysoft.co.uk)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

if ( !isset($_POST['name']) ) {
	print "<h1>Invalid input</h1>";
	exit;
}

header("Location: index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">

<?php
if ( isset($_POST['resign']) ) {
	if ( $_POST['resign'] == "Resign" ) {
		$mydb=pg_connect("host=localhost port=5432 dbname=oddsboard user=oddsboard password=23498723");
		$myrows=pg_query($mydb,"UPDATE odds SET odds='1-1' WHERE name='" . $_POST['name'] ."' AND crossed_out=false");
		$myrows=pg_query($mydb,"UPDATE odds SET crossed_out=true WHERE name='" . $_POST['name'] ."' AND crossed_out=false");
		pg_close($mydb);
	}
}

if ( isset($_POST['gone']) ) {
	if ( $_POST['gone'] == "Gone" ) {
		$mydb=pg_connect("host=localhost port=5432 dbname=oddsboard user=oddsboard password=23498723");
		$myrows=pg_query($mydb,"UPDATE odds SET odds='1-1' WHERE name='" . $_POST['name'] ."' AND gone=false");
		$myrows=pg_query($mydb,"UPDATE odds SET gone=true WHERE name='" . $_POST['name'] ."' AND gone=false");
		pg_close($mydb);
	}
}

if ( isset($_POST['unresign']) ) {
	if ( $_POST['unresign'] == "Do an Eamonn" ) {
		$mydb=pg_connect("host=localhost port=5432 dbname=oddsboard user=oddsboard password=23498723");
		$myrows=pg_query($mydb,"UPDATE odds SET odds='$$$-1' WHERE name='" . $_POST['name'] ."' AND crossed_out=true");
		$myrows=pg_query($mydb,"UPDATE odds SET crossed_out=false WHERE name='" . $_POST['name'] ."' AND crossed_out=true");
		pg_close($mydb);
	}
}

if ( isset($_POST['ungone']) ) {
	if ( $_POST['ungone'] == "Re-employed" ) {
		$mydb=pg_connect("host=localhost port=5432 dbname=oddsboard user=oddsboard password=23498723");
		$myrows=pg_query($mydb,"UPDATE odds SET odds='?-1' WHERE name='" . $_POST['name'] ."' AND gone=true");
		$myrows=pg_query($mydb,"UPDATE odds SET gone=false WHERE name='" . $_POST['name'] ."' AND gone=true");
		pg_close($mydb);
	}
}

if ( isset($_POST['delete']) ) {
	if ( $_POST['delete'] == "Delete" ) {
		$mydb=pg_connect("host=localhost port=5432 dbname=oddsboard user=oddsboard password=23498723");
		$myrows=pg_query($mydb,"DELETE FROM odds WHERE name='" . $_POST['name'] ."'");
		pg_close($mydb);
	}
}

if ( isset($_POST['changeodds']) ) {
	if ( $_POST['changeodds'] == "Change Odds" ) {
		$mydb=pg_connect("host=localhost port=5432 dbname=oddsboard user=oddsboard password=23498723");
		$myrows=pg_query($mydb,"UPDATE odds SET previousodds=odds WHERE name='" . $_POST['name'] ."' AND crossed_out=false");
		$myrows=pg_query($mydb,"UPDATE odds SET time=NOW() WHERE name='" . $_POST['name'] ."' AND crossed_out=false");
		$myrows=pg_query($mydb,"UPDATE odds SET odds='" . $_POST['odds'] . "' WHERE name='" . $_POST['name'] ."' AND crossed_out=false");
		pg_close($mydb);
	}
}

?>
