<?php 
function make($str) {
    $newstr = $str;
    $newstr = preg_replace("/<p.*?>|<\/p>/is","", $newstr);
    $newstr = preg_replace("/<div.*?>|<\/div>/is","", $newstr);
    /*$newstr = preg_replace("/<span.*?>|<\/span>/is","", $newstr);*/
    return $newstr;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $MSG_PROBLEM;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
<div class="row" style="margin: 3% 10% 5% 10%">
<div class="col-md-8">
        <div class="card">
  <div class="card-body">
    <?php
				if ( $pr_flag ) {
					echo "<h3>P$id: " . $row[ 'title' ] . "</h3>";
				} else {
					//$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$id = $row[ 'problem_id' ];
					echo "<h3>$MSG_PROBLEM " . $PID[ $pid ] . ": " . $row[ 'title' ] . "</h3>";
				}
				if ( $row[ 'spj' ] )echo $MSG_SPJ.'/';
	?><hr/>
	<?php 
	if ($row['description']) {
	    ?><h4><?php echo $MSG_Description;?></h4><?php
	    echo make($row['description']);
	}
	?>
	<?php 
	if ($row['input']) {
	    ?><h4><?php echo $MSG_Input;?></h4><?php
	    echo $row['input'];
	}
	?>
	<?php 
	if ($row['output']) {
	    ?><h4><?php echo $MSG_Output;?></h4><?php
	    echo $row['output'];
	}
	$sinput=str_replace("<","&lt;",$row['sample_input']);
    $sinput=str_replace(">","&gt;",$sinput);
    $soutput=str_replace("<","&lt;",$row['sample_output']);
    $soutput=str_replace(">","&gt;",$soutput);
	?>
	<div id="qwqs1">
	<?php 
	if (strlen($sinput)) {
	    ?><h4><?php echo $MSG_Sample_Input;?><a class="badge badge-outline-info" href="#" id="qwqa1">复制</a></h4><blockquote id="sampleInput"><pre><?php
	    echo $sinput."</pre></blockquote>";
	}
	?>
	</div>
	<div id="qwqs2">
	<?php 
	if (strlen($soutput)) {
	    ?><h4><?php echo $MSG_Sample_Output;?> <a class="badge badge-outline-info" href="#" id="qwqa2">复制</a></h4><blockquote id="sampleOutput"><pre><?php
	    echo $soutput.'</pre></blockquote>';
	}
	?>
	</div>
	<?php 
	if ($row['hint']) {
	    ?><h4><?php echo $MSG_HINT;?></h4><?php
	    echo $row['hint'];
	}
	?>
	<?php 
	if ($pr_flag) {
	    echo "<h4>$MSG_Source</h4>";
              $cats=explode(" ",$row['source']);
              foreach($cats as $cat){
                echo "<a href='problemset.php?search=".urlencode(htmlentities($cat,ENT_QUOTES,'utf-8'))."'>".htmlentities($cat,ENT_QUOTES,'utf-8')."</a>&nbsp;";
            }
	}
	?>
    </div>
</div>
</div>
<div class="col-md-4">
<div class="card">
<div class="card-body">
<h4>问题信息</h4>
<b><?php echo $MSG_Time_Limit;?></b> <?php echo $row['time_limit'];?>s<br>
<b><?php echo $MSG_Memory_Limit;?></b> <?php echo $row['memory_limit'];?>MB<br>
<b>评测方式</b> <?php echo $row['spj']?"Special Judge":"Normal Judge";?>
</div>
</div>
<br>
<div class="card">
<div class="card-body">
<h4>咻咻~</h4>
<a class="btn btn-info" href="<?php if ( $pr_flag ) { echo "submitpage.php?id=$id";} else { echo "submitpage.php?cid=$cid&pid=$pid&langmask=$langmask";}?>"><?php echo $MSG_SUBMIT;?></a>
<a class="btn btn-warning" href="<?php echo "status.php?problem_id=" . $row[ 'problem_id' ];?>"><?php echo $MSG_STATUS;?></a>
 <?php 
  if ( isset( $_SESSION[ $OJ_NAME . '_' . 'administrator' ] )||isset($_SESSION[$OJ_NAME.'_'.'problem_manager']) ) {
					require_once( "include/set_get_key.php" );
  ?><hr/>
<a class="btn btn-success" href="bsadmin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>"><?php echo $MSG_EDIT;?></a>
<a class="btn btn-danger" href='javascript:phpfm(<?php echo $row['problem_id'];?>)'><?php echo $MSG_TESTDATA;?></a>
  <?php } ?>
</div>
</div>
</div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
<script>
	function phpfm( pid ) {
		//alert(pid);
		$.post( "admin/phpfm.php", {
			'frame': 3,
			'pid': pid,
			'pass': ''
		}, function ( data, status ) {
			if ( status == "success" ) {
				document.location.href = "admin/phpfm.php?frame=3&pid=" + pid;
			}
		} );
	}

		function CopyToClipboard (input) {
			var textToClipboard = input;
			 
			var success = true;
			if (window.clipboardData) { // Internet Explorer
			    window.clipboardData.setData ("Text", textToClipboard);
			}
			else {
				// create a temporary element for the execCommand method
			    var forExecElement = CreateElementForExecCommand (textToClipboard);
			 
				    /* Select the contents of the element 
					(the execCommand for 'copy' method works on the selection) */
			    SelectContent (forExecElement);
			 
			    var supported = true;
			 
				// UniversalXPConnect privilege is required for clipboard access in Firefox
			    try {
				if (window.netscape && netscape.security) {
				    netscape.security.PrivilegeManager.enablePrivilege ("UniversalXPConnect");
				}
			 
				    // Copy the selected content to the clipboard
				    // Works in Firefox and in Safari before version 5
				success = document.execCommand ("copy", false, null);
			    }
			    catch (e) {
				success = false;
			    }
			 
				// remove the temporary element
			    document.body.removeChild (forExecElement);
			}
			 
			if (success) {
			    console.log(input);
			}
			else {
			    console.log("Can't");
			}
			}
			 
			function CreateElementForExecCommand (textToClipboard) {
			var forExecElement = document.createElement ("pre");
			    // place outside the visible area
			forExecElement.style.position = "absolute";
			forExecElement.style.left = "-10000px";
			forExecElement.style.top = "-10000px";
			    // write the necessary text into the element and append to the document
			forExecElement.textContent = textToClipboard;
			document.body.appendChild (forExecElement);
			    // the contentEditable mode is necessary for the  execCommand method in Firefox
			forExecElement.contentEditable = true;
			 
			return forExecElement;
			}
			 
			function SelectContent (element) {
			    // first create a range
			var rangeToSelect = document.createRange ();
			rangeToSelect.selectNodeContents (element);
			 
			    // select the contents
			var selection = window.getSelection ();
			selection.removeAllRanges ();
			selection.addRange (rangeToSelect);
			}
	$('#qwqa1').click(function() {
		CopyToClipboard($('#sampleInput').text());
		swal("样例输入复制成功","","success");
	});
	$('#qwqa2').click(function() {
		CopyToClipboard($('#sampleOutput').text());
		swal("样例输出复制成功","","success");
	});
</script>
    </body>
</html>