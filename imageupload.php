<?php

	//setting directory for image upload
	if ($_GET['page'] == 'create')
	{
		$targetDir = "images/$type/";
	}
	elseif ($_GET['page'] == 'user')
	{
		$targetDir = "images/user/";
	}
	
	$targetFile = $targetDir . basename($_FILES["image"]["name"]);
	$uploadOk = 1;
	$fileNotImage = 0;
	$fileExists = 0;
	$fileTooBig = 0;
	$wrongFileType = 0;
	$imageFileType = pathinfo($targetFile,PATHINFO_EXTENSION);
	
	// Check id image file is an actual image or fake image
	
	if(isset($_POST['Create']) || isset($_POST['Register']))
	{
		$check = getimagesize($_FILES["image"]["tmp_name"]);
		if($check !== false) 
		{
			$uploadOk = 1;
		}
		else
		{
			$uploadOk = 0;
			$imageError = 'File is not an image';
		}
	}
	
	// Check regex to insure compliant file name
	
	if(!preg_match('^[\w,\s-]{1, 251}+\.[A-Za-z]{3, 4}$', $targetFile))
	{
		$uploadOk = 0;
		$imageError = 'File name is invalid.'
	}
	
	
	// Check for duplicate file
	
	if(file_exists($targetFile))
	{
		$imageError = 'Sorry, that file already exists.';
		$uploadOk = 0;
	}
	
	// Check file size
	
	if($_FILES["image"]["size"] > 1000000)
	{
		$imageError = 'Sorry, your file is too large'
		$uploadOk = 0;
	}
	
	// Check file format
	
	if($imageFileType != "gif" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "jpg")
	{
		$imageError = 'Sorry, only JPG, JPEG, PNG and GIF files are allowed';
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is true try to upload image and set path as DB value
	
	if ($uploadOk == 1)
	{
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile))
		{
			$image = $targetFile;
		}
		else
		{
			$imageError = 'Sorry, there was an error uploading your file';
		}
	}
	
	
?>