<?php

/*****YoukuUpload SDK*****/
//header('Content-type: text/html; charset=utf-8');
//include("../youku/YoukuUploader.php"); 
class CYouku extends YoukuUploader
{

	public static function uploadVideo($video_path)
	{
		$file = $_FILES['video'];
		$client_id = "a2625d1b601d9ded"; // Youku cloud client_id
		$client_secret = "ecf221071066f845ca9aee94b3fba7b9"; //Youku cloud client_secret
		
		$params['access_token'] = "0a6ba5296b6f3b3d6e5a3c4185b899c8";
		$params['refresh_token'] = "2f70e474875fa8d6ccf093495c58be66";
		if(!file_exists($video_path)){
			mkdir($video_path,0777,true);
		}
		
		$file_name = $video_path .'/'. $file["name"]; //video file
		if(move_uploaded_file($file['tmp_name'], $file_name))
		{
			$youkuUploader = new YoukuUploader($client_id, $client_secret);
			try {
					$file_md5 = @md5_file($file_name);
						
					if (!$file_md5) 
					{
					
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
				unlink($file_name);
				return $arr["videoid"];
			}
		
			 

		}

	}
}

?>

