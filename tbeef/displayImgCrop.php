 <?php
		header("content-type:text/html;charset=UTF-8");
		include_once "../config/config.php";
		include_once "../config/database.php";	
		include_once "../objects/tbeef.php";

		$cnf=new Config();
		$rootPath=$cnf->path;
		$aiURL=$cnf->deepURL;
		$picPath=$cnf->picPath;
		$database=new Database();
		$db=$database->getConnection();
		$obj=new tbeef($db);
		$folder=isset($_GET["folder"])?$_GET["folder"]:"N001";
		$picture=isset($_GET["picture"])?$_GET["picture"]:"1.jpg";

		$physicalPath=$folder."/".$picture;

		$picture=$cnf->picPath.$folder."/".$picture;

		//print($picture);


		$size=$obj->getImageSize($picture);

		//echo json_encode($size);

		$sizeStyle="width:".$size["width"]."px;height:".$size["height"]."px";
		//print_r($sizeStyle);
		$sizeW=$size["width"];
		$sizeH=$size["height"];
		//print_r($cnf->picPath);
		//print_r($physicalPath);
		echo '<input type="hidden" id="hdn_picture" value="'.$physicalPath.'">';
?>

 <div style="overflow:scroll; height:500px;width:100%"> 
  		<img src="<?=$picture?>" id="cropbox" style="<?=$sizeStyle?>"  />
 </div>

 <link rel="stylesheet" href="<?=$rootPath?>/css/jquery.Jcrop.min.css" type="text/css" />
<script src="<?=$rootPath?>/js/jquery.min.js"></script>
<script src="<?=$rootPath?>/js/jquery.Jcrop.min.js"></script>
<script src="<?=$rootPath?>/js/component.js"></script>

 <script>

 	function execPost(url,jsonObj){
    var jsonData=JSON.stringify (jsonObj);
    var result;
      $.ajax({
        //**************
          url: url,
          contentType: "application/json; charset=utf-8",
          type: "POST",
          dataType: "json",
          data:jsonData,
          async:false,
          success: function(data){
            result=data;
          } 
        //**************
      });
      return result;
  }

  function displayCrop(){
  	
  	let length = beefInfos.length;
  	strT="<table width='100%' border='1'>\n";
  	strT+="<thead>\n";
  	strT+= "<tr><th colspan='3'><h3>ข้อมูลการประเมินคุณภาพเนื้อ</h3></th></tr>\n";
  	strT+="<th>ไขมันแทรก</th>\n";
  	strT+="<th>เนื้อแดง</th>\n";
  	strT+="<th>สัดส่วน(%)</th>\n";
  	strT+="</thead>\n";
  	strT+="<tbody>\n";
  	for(i=0;i<length;i++){
  		strT+="<tr>\n";
  		strT+="<td>"+beefInfos[i].fatArea+"</td>\n";
  		strT+="<td>"+beefInfos[i].beefArea+"</td>\n";
  		strT+="<td>"+beefInfos[i].ratio.toFixed()+" %</td>\n";
  		strT+="</tr>\n";
  	}
  	strT+="</tbody>\n";
  	strT+="</table>\n";
  	$("#dvCropInfo").html(strT);
  }

   function displayResult(){
   		var beefCode=$("#obj_beefCode").val();
   		var beefNo=$("#obj_beefNo").val();
   		var url="<?=$rootPath?>/telementtransaction/displayData.php?beefCode="+beefCode+"&beefNo="+beefNo;
   		$("#dvCropInfo").load(url);
   }

  	function createByCrop(data,beefCode,beefNo){
		var url="<?=$rootPath?>/telementtransaction/create.php";
		//var square=JSON.stringify(data.square);
    console.log(url);
		square=JSON.stringify(data.area);
		console.log(JSON.stringify(data));
		var jsonObj={
  			fat:data.fatArea,
  			beef:data.beefArea,
  			ratio:data.ratio,
  			beefCode:beefCode,
  			beefNo:beefNo,
  			square:square,
        fraction:data.fraction
  		}

  		jsonData=JSON.stringify(jsonObj);
  		console.log(jsonData);

  		var flag=executeData(url,jsonObj);
  		return flag;
  	}

 	$(document).ready(function(){
 		var size;
 		var jsonInfos;
  		var sizeW=<?=$sizeW?>;
  		var sizeH=<?=$sizeH?>;
  		var file=$("#hdn_picture").val();
        
		        $('#cropbox').Jcrop({

		          aspectRatio: 1,
		          onSelect: function(c){
		           size = {x:c.x,y:c.y,w:c.w,h:c.h};
		           area={
		              x1:c.x,
		              y1:c.y,
		              x2:c.w+c.x,
		              y2:c.h+c.y,
		              W:sizeW,
		              H:sizeH
		            };
		             //console.log(area);  
		             var jsonObj={
		             	file:file,area:area
		             }

		             var jsonData=JSON.stringify(jsonObj);

		             var url="<?=$aiURL?>/getElementDetail";
                 console.log(url);
                 console.log(jsonData);
		             var data=execPost(url,jsonObj);
		             //console.log(JSON.stringify(data));
		             if(data.beefArea!==0&&data.fatArea!==0){

		             	var flag= createByCrop(data,$("#obj_beefCode").val(),$("#obj_beefNo").val());

		             }

		             displayResult();
		             

		          }



		        });

 	});
 </script> 

