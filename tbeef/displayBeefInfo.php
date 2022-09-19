<?php
      include_once '../config/database.php';
      include_once '../config/config.php';
      include_once '../objects/classLabel.php';
      $cnf=new Config();
      $module=$cnf->systemModule;

      $rootPath=$cnf->path;
      $picPath=$cnf->picPath;
      $database = new Database();
      $db = $database->getConnection();
      $objLbl=new ClassLabel($db);

      function mb_basename($path) {
            if (preg_match('@^.*[\\\\/]([^\\\\/]+)([\\\\/]+)?$@s', $path, $matches)) {
                return $matches[1];
            } else if (preg_match('@^([^\\\\/]+)([\\\\/]+)?$@s', $path, $matches)) {
                return $matches[1];
            }
            return '';
      }
      $dir= getcwd();

      $lastPath=mb_basename($dir);
      $lblInput= $objLbl->getLabel("t_beef","BeefInfomation","th");


?>

<style>
	.crop {
	    padding: 5px 25px 5px 25px;
	    background: lightseagreen;
	    border: #485c61 1px solid;
	    color: #FFF;
	    visibility: hidden;
	}

	#obj_cropImg {
	    margin-top: 40px;
	}
</style>

<input type='hidden' id='obj_beefCode' value=''>
<input type='hidden' id='obj_beefNo' value=''>

<section class="content-header">
     <h1>
        <b><?=$module?></b>

        <small>>><?=$lblInput?></small>
      </h1>
      <ol class="breadcrumb">
       <a href="#" class="btn btn-success pull-right"><i class="fa fa-search" aria-hidden="true">Classify</i></a>
      </ol>

    </section>

       <section class="content container-fluid">
        <div class="box"></div>
         <div class="col-sm-12">
         	 <div class="box box-warning">
					<div class="box-header with-border">
					<h3 class="box-title"><b><?=$lblInput?></b></h3>
					</div>
					 <table id="tblMain" class="table table-bordered">
		 <tr>
		 	<td>
		 		<table >
		 			<tr>
		      		<td width="150px">ข้อมูลเนื้อ</td>
		      		<td width="450px">
		      			<select class="form-control" id="obj_Beef"></select>
		      		</td>
		      	</tr>
		 		</table>
		 	</td>
		 </tr>     	
      	 </table>

      	 <table width="100%">
      	 	<tr>
      	 		<td >
      	 		<div class="box box-primary">
      	 			 <div  class="col-sm-2" >
      	 			 	<table width="100%" id="tblBeefList"  class="table table-bordered table-hover">

      	 			 	</table>
			        </div>
			        <div id="dvRender" class="col-sm-10 img" >
			            <div style="style:overflow: scroll;">
			            <!--<img src="/BeefAPI/IMG/Beef.jpg" id="obj_cropImg" style="width:100%;height:700px" />-->
                    	<div id="imgCrop"></div>
			            </div>
			        </div>

		        	<div id="dvClassify" class="col-sm-3">
		        	</div>
		        	<div id="dvCropInfo" class="col-sm-5">
		        	</div>
		        	<div id="dvSumary" class="col-sm-4">
		        	</div>
			        
			      </div>
      	 		</td>
      	 	</tr>
      	 </table>
		</div>
         </div>
      </section>
</section>
<link rel="stylesheet" href="jquery.Jcrop.min.css" type="text/css" />
<script src="jquery.min.js"></script>
<script src="jquery.Jcrop.min.js"></script>

<script>
	
	var beefInfos=[];

	function listBeef(){
		var url="<?=$rootPath?>/tbeef/listBeef.php";
		setDDLPrefix(url,"#obj_Beef","***Raw Beef***")
	}

	function setImgList(folder){
		var url="<?=$rootPath?>/tbeefclassify/getImgFromFolder.php?folder="+folder;
		$("#tblBeefList").load(url);
		
	}

	function getImgInfo(folder,file,beefNo){
		var url="<?=$rootPath?>/tbeefclassify/getBeefElementOne.php?folder="+folder+"&file="+file+"&beefNo="+beefNo;
		$("#obj_beefNo").val(beefNo);
		$("#obj_beefCode").val(folder);
		$("#dvClassify").load(url);
		clearData();
	}	


  function displayImgCrop(folder,picture){
      var url="<?=$rootPath?>/tbeef/displayImgCrop.php?foder="+folder+"&picture="+picture;
      $("#imgCrop").load(url);
  }

  function clearData(){
  	beefInfos=[];
  	$("#dvCropInfo").html("");
  }

	function getClassify(imgName,beefNo){
		var url="<?=$picPath?>/"+$("#obj_Beef").val()+"/"+imgName;
		$("#obj_cropImg").attr("src",url);
		getImgInfo($("#obj_Beef").val(),imgName,beefNo);
		displayImgCrop($("#obj_Beef").val(),imgName);
	}

	function confirmDelete(id){
		swal.fire({
			title: "คุณต้องการที่จะลบข้อมูลนี้หรือไม่?",
			text: "***กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนกดปุ่มตกลง",
			type: "warning",
			confirmButtonText: "ตกลง",
			cancelButtonText: "ยกเลิก",
			showCancelButton: true,
			showConfirmButton: true
		}).then((willDelete) => {
		if (willDelete.value) {
			url="<?=$rootPath?>/telementtransaction/delete.php?id="+id;
			executeGet(url,false,"");
			displayResult();
		swal.fire({
			title: "ลบข้อมูลเรียบร้อยแล้ว",
			type: "success",
			buttons: "ตกลง",
		});
		} else {
			swal.fire({
			title: "ยกเลิกการทำรายการ",
			type: "error",
			buttons: [false, "ปิด"],
			dangerMode: true,
		})
		}
		});
}

  

	$(document).ready(function(){
		listBeef();
		setImgList("N001");
		$("select#obj_Beef").prop('selectedIndex', 1);

		$("#obj_Beef").change(function(){
				setImgList($("#obj_Beef").val());
				
		});
	});
</script>