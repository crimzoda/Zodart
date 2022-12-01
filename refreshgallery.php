<?php
    //this is a cron job that refreshes the displayed gallery everyday
	$conn = mysqli_connect("localhost", "username", "password", 'db') or die(mysqli_connect_error());
	
    //the display from the previos day is cleared
	$clearDisplayQuery = "DELETE FROM display";
    /*the auto increment is set back to one so that it doesn't
    keep adding from day to day*/
	$resetIncrement = "ALTER table display AUTO_INCREMENT = 1";
    //3 rows are randomly inserted into the display table from the gallery table
	$addDisplayQuery = "INSERT INTO display(title, url, author, pos) SELECT title, url, author, pos FROM gallery ORDER BY RAND() LIMIT 3";
	/*deletes the selected rows from gallery to avoid clutter and repeat selections in the future.
	deletes the rows by comparing pos value in display table rows with rows with the sam pos value 
	in the gallery table*/
	$removeFromGallery = "DELETE t1 FROM gallery t1 JOIN display t2 ON t1.pos = t2.pos";

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

	if (mysqli_query($conn, $removeFromGallery))
	{
		echo "Submitted!";
	}
	else
	{
		echo "Oh no something happened, it didn't work..." . mysqli_error($conn);
	}
		
	mysqli_close($conn);
?>