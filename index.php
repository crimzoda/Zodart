<!DOCTYPE html>
<html>
<head>
	<title>The gallery</title>
	<meta name = "description" content="Submit your art! Everyday, three submissions are chosen and displayed.">
</head>
<?php
        /*getImages will return the title, url or author depending on the
        arguments passed*/
		function getImages($id, $type)
		{
			$conn = new mysqli("localhost", "username", "password", 'db') or die(mysqli_connect_error());
			
			if ($conn->connect_error)
			{
				die("connection failed" . $conn->connect_error);
			}
			
			//selects the row that matched the $id that was passed
			$stmnt = $conn->prepare("SELECT * FROM display WHERE id = ?");
			$stmnt->bind_param('s', $id);
			$stmnt->execute();
			
			$result = $stmnt->get_result();
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
            //gets the appropriate item/value
			switch ($type)
			{
				case 0:
					echo $row['title'];
					break;
				case 1:
					echo $row['url'];
					break;
				case 2:
					echo $row['author'];
					break;
			}
			
			
			$stmnt->close();
			$conn->close();

		}
	
		if (isset($_POST['upload']))
		{
			upload();
		}
	
        //upload function will insert the users submission into the database table
		function upload()
		{
			$conn = mysqli_connect("localhost", "username", "password", 'db') or die(mysqli_connect_error());
	
			if ($conn == false)
			{
				die("ERROR: Could not connect!" . mysqli_connect_error());
			}
			
            //gets the submission inputs
			$title = $_REQUEST['title'];
			$url = $_REQUEST['url'];
			$author = $_REQUEST['author'];
            
            /*checks to make sure no invalid values are inserted.
            'getimagesize($url)' is used to make sure the url is actually an image*/
			if ($title != '' AND $url != '' AND $author != '' AND getimagesize($url))
			{
                echo "Image URL is valid!";

                //finally the details are inserted into the database
                $sql_stmnt = $conn->prepare("INSERT INTO `gallery` (`title`, `url`, `author`) VALUES (?, ?, ?)");
				$sql_stmnt->bind_param('sss', $title, $url, $author);
				$sql_stmnt->execute();
			}
			
			mysqli_close($conn);
			
			header("Location: https://zodart.com/");
			die();
		}
		

	?>

	<body>
		<div class="div1">
			<link rel="stylesheet" href="styles.css" />
			<link rel="icon" type="image/x-icon" href="favicon.ico"/>
			<div class="content" id="form-box">
				<form enctype="multipart/form-data" method="POST">
					<p>submit</p>
					<label for="ftitle">title:</label>
					<input type="text" name="title">
					<br>
					<label for="furl">url:</label>
					<input type="text" name="url">
					<br>
					<label for="fauthor">author:</label>
					<input type="text" name="author">
					<br>
					<input type="submit" name="upload" id="Submit" /> </form>
				<label style="font-size: 12px">By submitting you agree you are not submitting anything illegal or pornographic</label>
			</div>
			<div id="center-stuff">
				<figure>
					<figcaption>
						<?php echo getImages(1, 0); ?>
					</figcaption> <a href="<?php echo getImages(1, 1); ?>"><img id="display-image" src="<?php echo getImages(1, 1); ?>" width=400 height=400 ></a>
					<figcaption>by
						<?php echo getImages(1, 2); ?>
					</figcaption>
				</figure>
				<figure>
					<figcaption>
						<?php echo getImages(2, 0); ?>
					</figcaption> <a href="<?php echo getImages(2, 1); ?>"><img id="display-image" src="<?php echo getImages(2, 1); ?>" width=400 height=400></a>
					<figcaption>by
						<?php echo getImages(2, 2); ?>
					</figcaption>
				</figure>
				<figure>
					<figcaption>
						<?php echo getImages(3, 0); ?>
					</figcaption> <a href="<?php echo getImages(3, 1); ?>"><img id="display-image" src="<?php echo getImages(3, 1); ?>" width=400 height=400></a>
					<figcaption>by
						<?php echo getImages(3, 2); ?>
					</figcaption>
				</figure>
				
			</div>
			<div style="text-align: center; font-size: 12px; margin-top: 100px;">
				<span>This site does not own any of the images displayed.</span>
			</div>
			<div style="position: fixed;
    bottom: 0;
    right: 0; margin: 40px;">
				<img src="info_graphic.png">
			</div>
		</div>
	</body>

</html>