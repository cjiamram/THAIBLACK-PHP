var regDec = /^\d+(\.\d{1,2})?$/;
var regEmail=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
var regTel=/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/g;
var regDate=/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
function validInput(){
		var flag=true;
		flag=regDec.test($("#obj_averageWeight").val());
		if (flag==false){
			$("#obj_averageWeight").focus();
			return flag;
}
		flag=regDate.test($("#obj_createDate").val());
		if (flag==false){
				$("#obj_createDate").focus();
				return flag;
		}
		return flag;
}
function displayData(){
		var url="tjudgiment/displayData.php?tableName=t_judgiment&dbName=dbbeefclassify&keyWord="+$("#txtSearch").val();
		$("#tblDisplay").load(url);
}
function createData(){
		var url='tjudgiment/create.php';
		jsonObj={
			userCode:$("#obj_userCode").val(),
			judgimentGrade:$("#obj_judgimentGrade").val(),
			averageWeight:$("#obj_averageWeight").val(),
			description:$("#obj_description").val(),
			createDate:$("#obj_createDate").val(),
			cowCode:$("#obj_cowCode").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function updateData(){
		var url='tjudgiment/update.php';
		jsonObj={
			userCode:$("#obj_userCode").val(),
			judgimentGrade:$("#obj_judgimentGrade").val(),
			averageWeight:$("#obj_averageWeight").val(),
			description:$("#obj_description").val(),
			createDate:$("#obj_createDate").val(),
			cowCode:$("#obj_cowCode").val(),
			id:$("#obj_id").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function readOne(id){
		var url='tjudgiment/readOne.php?id='+id;
		data=queryData(url);
		if(data!=""){
			$("#obj_userCode").val(data.userCode);
			$("#obj_judgimentGrade").val(data.judgimentGrade);
			$("#obj_averageWeight").val(data.averageWeight);
			$("#obj_description").val(data.description);
			$("#obj_createDate").val(data.createDate);
			$("#obj_cowCode").val(data.cowCode);
			$("#obj_id").val(data.id);
		}
}
function saveData(){
		var flag;
		flag=validInput();
		if(flag==true){
					if($("#obj_id").val()!=""){
			flag=updateData();
			}else{
			flag=createData();
		}
		if(flag==true){
			swal.fire({
			title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",
			type: "success",
			buttons: [false, "ปิด"],
			dangerMode: true,
		});
		displayData();
		}
		else{
			swal.fire({
			title: "การบันทึกข้อมูลผิดพลาด",
			type: "error",
			buttons: [false, "ปิด"],
			dangerMode: true,
		});
		}
		}else{
			swal.fire({
			title: "รูปแบบการกรอกข้อมูลไม่ถูกต้อง",
			type: "error",
			buttons: [false, "ปิด"],
			dangerMode: true,
			});
			}
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
			url="tjudgiment/delete.php?id="+id;
			executeGet(url,false,"");
			displayData();
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
function clearData(){
			$("#obj_userCode").val("");
			$("#obj_judgimentGrade").val("");
			$("#obj_averageWeight").val("");
			$("#obj_description").val("");
			$("#obj_createDate").val("");
			$("#obj_cowCode").val("");
}
function genCode(){
		//var url="genCode.php";
		//var data=queryData(url);
		//return data.code;
}
