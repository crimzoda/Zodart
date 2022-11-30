<?php
    //this is a cron job that refreshes the displayed gallery everyday
	$conn = mysqli_connect("localhost", "username", "password", 'table') or die(mysqli_connect_error());
	
    //the display from the previos day is cleared
	$clearDisplayQuery = "DELETE FROM display";
    /*the auto increment is set back to one so that it doesn't
    keep adding from day to day*/
	$resetIncrement = "ALTER table display AUTO_INCREMENT = 1";
    $selectedItems = mysqli_query($conn, "SELECT title, url, author FROM gallery ORDER BY RAND() LIMIT 3");
    //3 rows are randomly inserted into the display table from the gallery table
	$addDisplayQuery = "INSERT INTO display(title, url, author) $selectedItems";
	/*removes the displayed items from the gallery to avoid repeat
	submissions being displayed*/
    $removeGalleryItems = "DELETE $selectedItems"

	if (mysqli_query($conn, $clearDisplayQuery))
	{
		echo "Display cleared!";
	}
	else
	{
		echo "Oh no something happened, it didn't work...";
	}

	if (mysqli_query($conn, $resetIncrement))
	{
		echo "Increment reset!";
	}
	else
	{
		echo "Oh no something happened, it didn't work..." . mysqli_error($conn);
	}

	if (mysqli_query($conn, $addDisplayQuery))
	{
		echo "Submissions added to display!";
	}
	else
	{
		echo "Oh no something happened, it didn't work..." . mysqli_error($conn);
	}

    if (mysqli_query($conn, $removeGalleryItems))
	{
		echo "Gallery submissions deleted!";
	}
	else
	{
		echo "Oh no something happened, it didn't work..." . mysqli_error($conn);
	}
		
	mysqli_close($conn);
?>