<?php
/*
Odds Board
Copyright (C) 2007 Gary Hawkins <gary.hawkins@garysoft.co.uk>

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

header('Pragma: no-cache');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">

<html>
<head>
<link rel="stylesheet" href="style.css">
<title>The Odds Board</title>
</head>

<body>

<div class="header">
<p class="header">
<h1 class="header">The Odds Board</h1>
<h2 class="header">Beta (Optimized for Firefox 2.0)</h2>
</p>
</div>

<div class="maintable">

<p><strong>Board Rules: </strong> 1. No libellous/slanderous/illegal odds.&nbsp;&nbsp;2. No bad language.&nbsp;&nbsp;3. No exploits.&nbsp;&nbsp;4. The Editor's decision is final.&nbsp;&nbsp;<strong>Warning: </strong>"Doing an Eamonn" may cause your career prospects to go down as well as up.  5. Comments/compliments/complaints on a postcard to the <A HREF="mailto:webmaster@garyhawkins.me.uk">usual address</A></p>

<?php
$mydb=pg_connect("host=localhost port=5432 dbname=oddsboard user=oddsboard password=23498723");
$myrows=pg_query($mydb,"SELECT * FROM odds ORDER BY gone DESC, crossed_out DESC, name ASC");

switch (pg_num_rows($myrows)) {
case 0:
	break;	
default:
	?>
<table class="maintable">
<?php 
	while ($singlerow=pg_fetch_row($myrows)) {
		if ($singlerow[2] == "t") $style=" STYLE=\"background-color: #f08080\"";
		if ($singlerow[2] == "f") $style=" STYLE=\"background-color: #80f080\"";
		if ($singlerow[5] == "t") $style=" STYLE=\"background-color: #000000; color: #ffffff;\"";

?>
		<tr class="maintable">
		<td class="maintable" <?php print $style; ?>>
		<h2 class="maintable">
<?php 
		if (($singlerow[2] == "t") || ($singlerow[5] == "t")) print "<strike>";
		print($singlerow[0]); 
		if (($singlerow[2] == "t") || ($singlerow[5] == "t")) print "</strike>";
?>
		</td>
		<td class="maintable" width="25%" <?php print $style; ?>>
		<h2 class="maintable" TITLE="Last updated: <?php print($singlerow[4]); ?>; Previous odds: <?php print($singlerow[3]); ?>">
<?php
		if (($singlerow[2] == "t") || ($singlerow[5] == "t")) print "<strike>";
		print($singlerow[1]); 
		if (($singlerow[2] == "t") || ($singlerow[5] == "t"))  print "</strike>";
?>
		</td>
		<td class="maintable" <?php print $style; ?>>
		<form method="post" action="update-db.php">
				<p style="margin: 0">
				&nbsp;
				<input type="hidden" name="name" value="<?php print $singlerow[0]; ?>"></input>
				<input type="text" size=5 name="odds" value="<?php print $singlerow[1] ?>"></input>&nbsp;
				<input type="submit" name="changeodds" value="Change Odds"></input>&nbsp;
				<input type="submit" name="delete" value="Delete"></input>&nbsp;
				<?php
				if (($singlerow[2] != "t") && ($singlerow[5] != "t")) {
					print ("<input type=\"submit\" name=\"resign\" value=\"Resign\"></input>&nbsp");
					print ("<input type=\"submit\" name=\"gone\" value=\"Gone\"></input>&nbsp");
				}
				?>
				<?php
				if (($singlerow[2] == "t") && ($singlerow[5] != "t")) {
					print ("<input type=\"submit\" name=\"unresign\" value=\"Do an Eamonn\"></input>&nbsp;");
				}
				if (($singlerow[5] == "t") && ($singlerow[2] != "t")) {
					print ("<input type=\"submit\" name=\"ungone\" value=\"Re-employed\"></input>&nbsp;");
				}
				?>
				</p>
		</form>
		</td>
		</tr>
<?php	
	}

}
?>
</table>

<form method="post" action="insert-new.php">
	<p>Insert new person:
	<input type="text" size=5 name="name" value="<?php print $singlerow[0]; ?>"></input>
	<input type="submit" name="add" value="Add"></input>&nbsp;
	</p>
</form>

</div>

</body>
