<?php
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/config.php";
	include_once "../lib/classAPI.php";
	include_once "../config/database.php";
	include_once "../objects/tclassifytransaction.php";

	$database=new Database();
	$db=$database->getConnection();
	$obj=new tclassifytransaction($db);
	$cnf=new Config();
	$api=new ClassAPI();

	$rootPath=$cnf->path;
	$picPath=$cnf->picPath;

	$folder=isset($_GET["folder"])?$_GET["folder"]:"";
	$file=isset($_GET["file"])?$_GET["file"]:"";
	$beefNo=isset($_GET["beefNo"])?$_GET["beefNo"]:"";



	$url=$cnf->deepURL."classifyBeefElementOne/".$folder."/".$file;

	$data=$api->getAPI($url);


	if($data!==""){
		
		
		$obj->beefCode=$folder;
		$obj->beefNo=$beefNo;
		//print_r();
		if(isset($data["beefGrades"]["class"])===true){
			$obj->grade=$data["beefGrades"]["class"];
			$obj->accuracy=$data["beefGrades"]["confidence"];
			

		}else{
			$obj->grade="";
			$obj->accuracy="";
			
		}

		
		$obj->beefNo=$beefNo;
		$obj->fat=$data["beefInfo"]["fat"];
		$obj->beef=$data["beefInfo"]["beef"];
		$obj->ratio=$data["beefInfo"]["ratio"];
		$id=intval($obj->getId($folder,$beefNo));
		$flag=false;
		if($id===0){
			$flag=$obj->create();
		}else{
			$obj->id=$id;
			$flag=$obj->update();

		}

		//print_r($flag);
		echo "<table  class=\"table table-bordered table-hover\" >\n";
		echo "<tr><th colspan='2'><label class='font-size:18px'>ข้อมูลเนื้อ</label></th></tr>\n";
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
				echo "<td>พื้นที่ไขมันพอก cm2 :</td>\n";
				echo "<td align='right'>".number_format(intval($data["beefInfo"]["fat"])*0.26458333/100,2,'.','')."</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
				echo "<td>พื้นที่เนื้อ cm2 :</td>\n";
				echo "<td align='right'>".number_format(intval($data["beefInfo"]["beef"])*0.26458333/100,2,'.','')."</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
				echo "<td>สัดส่วนไขมันพอก/เนื้อ :</td>\n";
				echo "<td align='right'>".number_format($data["beefInfo"]["ratio"],2,'.','')."%</td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}



?>