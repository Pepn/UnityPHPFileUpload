<?php
$csv_mimetypes = array(
    'text/csv',
    'text/plain',
    'application/csv',
    'text/comma-separated-values',
    'application/excel',
    'application/vnd.ms-excel',
    'application/vnd.msexcel',
    'text/anytext',
    'application/octet-stream',
    'application/txt',
);

if ( isset($_FILES["dataFile"])) {

	//check password
	$auth = $_SERVER['HTTP_AUTH'];
    if($auth != "YOUR PASSWORD HERE LOL"){
        echo "Password Incorrect!";
        return;
    }
	
	//if there was an error uploading the file
	if ($_FILES["dataFile"]["error"] > 0)
		echo "Return Code: " . $_FILES["dataFile"]["error"] . "<br />";
	else{
		$filename = $_FILES["dataFile"]["name"];
		$dupFilename = rtrim($filename , ".csv") . "_1.csv";

		if (in_array($_FILES["dataFile"]["type"], $csv_mimetypes)) {
			if(file_exists("data/" . $filename)){ // file exists
				if (file_exists("data/" . $dupFilename)) // duplicate exists
					echo " FILE OK - IGNORED as duplicate "; //just ignore it
				else{
					move_uploaded_file($_FILES["dataFile"]["tmp_name"], "data/" . $dupFilename); //add as duplicate
					echo " FILE OK - as duplicate ";
					echo "Stored in: " . "data/" . $dupFilename;
				}
			}else{ // new file
				move_uploaded_file($_FILES["dataFile"]["tmp_name"], "data/" . $filename);
				echo " FILE OK ";
				echo "Stored in: " . "data/" . $filename . " ";
				return;
			}
		}
	}
}
else
	echo "FILE NOT SET";
     
 ?>