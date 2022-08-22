<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	include_once "../lib/classAPI.php";

	$cnf=new Config();
	$api=new ClassAPI();

	$rootPath=$cnf->path;
	$picPath=$cnf->picPath;

	$folder=isset($_GET["folder"])?$_GET["folder"]:"";
	$file=isset($_GET["file"])?$_GET["file"]:"";



	$url=$cnf->deepURL."classifyBeefElementOne/".$folder."/".$file;

	$data=$api->getAPI($url);

	//print_r($url);

	//print_r($data);

	if($data!==""){
		echo "<Table  border='1' width='100%'>\n";
		echo "<tr><th colspan='2'><h3>ข้อมูลเนื้อ</h3></th></tr>\n";
		if(count($data["beefGrades"])>0){
			echo "<tr>\n";
				echo "<td width='200px'>เกรด :</td>\n";
				echo "<td align='center'>".$data["beefGrades"]["class"]."</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
				echo "<td>ความถูกต้อง :</td>\n";
				echo "<td align='right'>".number_format($data["beefGrades"]["confidence"],2,'.','')."%</td>\n";
			echo "</tr>\n";
		}
		if(count($data["beefInfo"])>0){
			echo "<tr>\n";
				echo "<td>ไขมันพอก :</td>\n";
				echo "<td align='right'>".number_format($data["beefInfo"]["fat"],2,'.','')."</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
				echo "<td>เนื้อ :</td>\n";
				echo "<td align='right'>".number_format($data["beefInfo"]["beef"],2,'.','')."</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
				echo "<td>สัดส่วนไขมันพอก/เนื้อ :</td>\n";
				echo "<td align='right'>".number_format($data["beefInfo"]["ratio"],2,'.','')."%</td>\n";
			echo "</tr>\n";
		}
		echo "</Table>\n";
	}



?>