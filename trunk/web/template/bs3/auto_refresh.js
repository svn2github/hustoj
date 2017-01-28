var i=0;
var interval=800;
function auto_refresh(){
	interval=800;
	var tb=window.document.getElementById('result-tab');
	var rows=tb.rows;
	for(var i=rows.length-1;i>0;i--){
		var cell=rows[i].cells[3].children[0].innerHTML;
		rows[i].cells[3].className="td_result";
		var sid=rows[i].cells[0].innerHTML;
	        for(var j=0;j<4;j++){
			if(cell.indexOf(judge_result[j])!=-1){
			   window.setTimeout("fresh_result("+sid+")",interval);
			   console.log("auto_refresh "+sid+" actived!");

               return;

			}
		}
	}
}
function findRow(solution_id){
	var tb=window.document.getElementById('result-tab');
	var rows=tb.rows;
	for(var i=1;i<rows.length;i++){
		var cell=rows[i].cells[0];
		if(cell.innerHTML==solution_id) return rows[i];
	}
}

function fresh_result(solution_id){
	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var tb=window.document.getElementById('result-tab');
			var row=findRow(solution_id);
			//alert(row);
			var r=xmlhttp.responseText;
			var ra=r.split(",");
			// alert(r);
			// alert(judge_result[r]);
			var loader="<img width=18 src=image/loader.gif>";
			row.cells[3].innerHTML="<span class='btn btn-warning'>"+judge_result[ra[0]]+"</span>"+loader;
			row.cells[4].innerHTML=ra[1];
			row.cells[5].innerHTML=ra[2];
			if(ra[0]<4){
				window.setTimeout("fresh_result("+solution_id+")",interval);
				interval*=2;
			}else{
				 row.cells[3].innerHTML="<span class='"+judge_color[ra[0]]+"'>"+judge_result[ra[0]]+"</span>";
				 auto_refresh();
                
			}
		}
	}
	xmlhttp.open("GET","status-ajax.php?solution_id="+solution_id,true);
	xmlhttp.send();
}
//<?php if ($last>0&&$_SESSION['user_id']==$_GET['user_id']) echo "fresh_result($last);";?>
//alert(123);
var hj_ss="<select class='http_judge form-control' length='2' name='result'>";
	for(var i=0;i<10;i++){
   		hj_ss+="	<option value='"+i+"'>"+judge_result[i]+" </option>";
	}
   hj_ss+="</select>";
   hj_ss+="<input name='manual' type='hidden'>";
   hj_ss+="<input class='http_judge form-control' size=5 title='输入判定原因与提示' name='explain' type='text'>";
   hj_ss+="<input class='http_judge btn' name='manual' value='确定' type='submit'>";
$(".http_judge_form").append(hj_ss);
$(".http_judge_form").submit(function (){
   var sid=this.children[0].value;
   $.post("admin/problem_judge.php",$(this).serialize(),function(data,textStatus){
   		if(textStatus=="success")window.setTimeout("fresh_result("+sid+")",1000);
	})
   return false;
});
auto_refresh();
$(".td_result").mouseover(function (){
//   $(this).children(".btn").hide(300);
   $(this).children(".http_judge_form").show(600);
});
$(".http_judge_form").hide();

