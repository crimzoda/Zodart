<?php
    //this is a cron job that refreshes the displayed gallery everyday
	$conn = mysqli_connect("localhost:3306", "b7v3ht", "A636*nq0l", 't6fpn7') or die(mysqli_connect_error());
	
    //the display from the previos day is cleared
	$clearDisplayQuery = "DELETE FROM display";
    /*the auto increment is set back to one so that it doesn't
    keep adding from day to day*/
	$resetIncrement = "ALTER table display AUTO_INCREMENT = 1";
    //3 rows are randomly inserted into the display table from the gallery table
	$addDisplayQuery = "INSERT INTO display(title, url, author) SELECT title, url, author FROM gallery ORDER BY RAND() LIMIT 3";

	if (mysqli_query($conn, $clearDisplayQuery))
	{
		echo "Submitted!";
	}
	else
	{
		echo "Oh no something happened, it didn't work...";
	}

	if (mysqli_query($conn, $resetIncrement))
	{
		echo "Submitted!";
	}
	else
	{
		echo "Oh no something happened, it didn't work..." . mysqli_error($conn);
	}

	if (mysqli_query($conn, $addDisplayQuery))
	{
		echo "Submitted!";
	}
	else
	{
		echo "Oh no something happened, it didn't work..." . mysqli_error($conn);
	}
		
	mysqli_close($conn);
?>