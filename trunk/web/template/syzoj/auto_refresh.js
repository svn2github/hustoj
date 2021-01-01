judge_result = Array("等待", "等待重判", "编译中", "运行并评判", "答案正确", "格式错误", "答案错误", "时间超限", "内存超限",
	"输出超限", "运行错误", "编译错误", "运行错误(点击看详细)", "编译错误(点击看详细)", "编译成功", "点击看详细", "人工判题");
judge_icon = Array(
	"<i class=\"hourglass half icon\"></i>",
	"<i class=\"hourglass half icon\"></i>",
	"<i class=\"spinner icon\"></i>",
	"<i class=\"spinner icon\"></i>",
	"<i class=\"checkmark icon\"></i>",
	"<i class=\"server icon\"></i>",
	"<i class=\"remove icon\"></i>",
	"<i class=\"clock icon\"></i>",
	"<i class=\"microchip icon\"></i>",
	"<i class=\"print icon\"></i>",
	"<i class=\"bomb icon\"></i>",
	"<i class=\"code icon\"></i>",
	"<i class=\"ban icon\"></i>",
	"<i class=\"file outline icon\"></i>",
	"<i class=\"server icon\"></i>",
	"<i class=\"folder open outline icon\"></i>",
	"<i class=\"minus icon\"></i>",
	"<i class=\"ban icon\"></i>"
);
judge_style = Array("waiting",
	"status waiting",
	"status compiling",
	"status running",
	"status accepted",
	"status judgement_failed",
	"status wrong_answer",
	"status time_limit_exceeded",
	"status memory_limit_exceeded",
	"status output_limit_exceeded",
	"status runtime_error",
	"status compile_error",
	"status invalid_interaction",
	"status file_error",
	"status system_error",
	"status no_testdata",
	"status partially_correct",
	"status skipped");

var i = 0;
var interval = 500;

function auto_refresh() {
	var tb = window.document.getElementById('vueAppFuckSafari');
	var rows = tb.rows;
	for(var i = rows.length - 1; i > 0; i--) {
		var result = $(rows[i].cells[3].children[0].innerHTML).attr("result");
		var sid = rows[i].cells[0].children[0].innerHTML;
		if(result < 4) {
			window.setTimeout("fresh_result(" + sid + ")", interval);
			console.log("auto_refresh " + sid + " actived!");
		}
	}
}

function findRow(solution_id) {
	var tb = window.document.getElementById('vueAppFuckSafari');
	var rows = tb.rows;
	for(var i = 1; i < rows.length; i++) {
		var cell = rows[i].cells[0].children[0];
		if(cell.innerHTML == solution_id) return rows[i];
	}
}

function fresh_result(solution_id) {
	//console.log("fresh_result " + solution_id + " actived!");
	var result_now = -1;
	result_now = $(findRow(solution_id).cells[3].children[0].innerHTML).attr("result");
	var xmlhttp;
	if(window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var tb = window.document.getElementById('vueAppFuckSafari');
			var row = findRow(solution_id);
			var r = xmlhttp.responseText;
			var ra = r.split(",");
			console.log("ra:" + ra[0] + " res:" + result_now);
			if(ra[0] != result_now) {
				console.log("rewrite");
				if(ra[0] < 4) {
					row.cells[3].innerHTML = "<b><span class='hidden' style='display:none' result='" + ra[0] + "' ></span><span class=\"" + judge_style[ra[0]] + "\">" + judge_icon[ra[0]] + judge_result[ra[0]] + "</span></b>";
					row.cells[4].innerHTML = "<b>---</b>";
					row.cells[5].innerHTML = "<b>---</b>";
					row.cells[9].innerHTML = "<b>" + ra[3] + "</b>";
				} else {
					if(ra[4] < 98 && ra[4] != 0) {
						row.cells[3].innerHTML = "<b><span class='hidden' style='display:none' result='" + ra[0] + "' ></span><span class=\"" + judge_style[ra[0]] + "\">" + judge_icon[ra[0]] + judge_result[ra[0]] + ra[4] + "%" + "</span></b>";
					} else {
						row.cells[3].innerHTML = "<b><span class='hidden' style='display:none' result='" + ra[0] + "' ></span><span class=\"" + judge_style[ra[0]] + "\">" + judge_icon[ra[0]] + judge_result[ra[0]] + "</span></b>";
					}

					row.cells[4].innerHTML = "<b>" + ra[1] + "</b>";
					row.cells[5].innerHTML = "<b>" + ra[2] + "</b>";
					row.cells[9].innerHTML = "<b>" + ra[3] + "</b>";

				}
			}
			if(ra[0] < 4) {
				window.setTimeout("fresh_result(" + solution_id + ")", interval);
			} else {
				auto_refresh();
			}
		}
	}
	xmlhttp.open("GET", "status-ajax.php?solution_id=" + solution_id, true);
	xmlhttp.send();
}
auto_refresh();
