<?php

/*****YoukuUpload SDK*****/
header('Content-type: text/html; charset=utf-8');
include("include/YoukuUploader.class.php");
function uploadVideo()
{

	move_uploaded_file($_FILES["video"]["tmp_name"],"../uploadVideo/" . $_FILES["video"]["name"]);
	
	$client_id = "a2625d1b601d9ded"; // Youku cloud client_id
	$client_secret = "ecf221071066f845ca9aee94b3fba7b9"; //Youku cloud client_secret
	
	$params['access_token'] = "0a6ba5296b6f3b3d6e5a3c4185b899c8";
	$params['refresh_token'] = "2f70e474875fa8d6ccf093495c58be66";
	
	set_time_limit(0);
	ini_set('memory_limit', '128M');
	$youkuUploader = new YoukuUploader($client_id, $client_secret);
	$file_name = "../uploadVideo/" . $_FILES["video"]["name"]; //video file
	
	try {
		$file_md5 = @md5_file($file_name);
	
		if (!$file_md5) {
			
			throw new Exception("Could not open the file!\n");
		}
	}catch (Exception $e) {
		echo "(File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
		return;
	}
	$file_size = filesize($file_name);
	$uploadInfo = array(
			"title" => "php播放sdk测试", //video title
			"tags" => "测试 原创", //tags, split by space
			"file_name" => $file_name, //video file name
			"file_md5" => $file_md5, //video file's md5sum
			"file_size" => $file_size //video file size
	);
	
	$progress = true; //if true,show the uploading progress
	$arr = $youkuUploader->upload($progress, $params,$uploadInfo);
	if($arr['status'] == "success")
	{
		return $arr["videoid"];
	}
	
	unlink($file_name); 
}






















