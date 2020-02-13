<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $MSG_PROBLEMS;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="row" style="margin: 3% 8% 5% 8%">
            <div class="col-md-8">
            <div class='card'>
  <div class="card-body">
    <h4><?php echo $MSG_PROBLEMS;?></h4>
				<?php if (!$_GET["search"]) { ?>
    <ul class="pagination">
						<li class="page-item"><a class="page-link" href="problemset.php?page=1">&lt;&lt;</a>
						</li>
						<?php
						if ( !isset( $page ) )$page = 1;
						$page = intval( $page );
						$section = 8;
						$start = $page > $section ? $page - $section : 1;
						$end = $page + $section > $view_total_page ? $view_total_page : $page + $section;
						for ( $i = $start; $i <= $end; $i++ ) {
							echo "<li class='" . ( $page == $i ? "active " : "" ) . "page-item'>
        <a class='page-link' href='problemset.php?page=" . $i . "'>" . $i . "</a></li>";
						}
						?>
						<li class="page-item"><a class="page-link" href="problemset.php?page=<?php echo $view_total_page?>">&gt;&gt;</a>
						</li>
					</ul><?php } ?>
    <table class="table table-hover">
    <thead>
						<tr class='toprow'>
							<th></th>
							<th class='hidden-xs'>
								id
							</th>
							<th>
								<?php echo $MSG_TITLE?>
							</th>
							<th class='hidden-xs'>
								<?php echo $MSG_SOURCE?>
							</th>
							<th style="cursor:hand">
								<?php echo $MSG_AC?>
							</th>
							<th style="cursor:hand">
								<?php echo $MSG_SUBMIT?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$cnt = 0;
						foreach ( $view_problemset as $row ) {
							if ( $cnt )
								echo "<tr class='oddrow'>";
							else
								echo "<tr class='evenrow'>";
							$i = 0;
							foreach ( $row as $table_cell ) {
								if ( $i == 1 || $i == 3 )echo "<td  class='hidden-xs'>";
								else echo "<td>";
								echo "\t" . $table_cell;
								echo "</td>";
								$i++;
							}
							echo "</tr>";
							$cnt = 1 - $cnt;
						}
						?>
					</tbody>
</table><?php if (!$_GET["search"]) { ?><ul class="pagination">
						<li class="page-item"><a class="page-link" href="problemset.php?page=1">&lt;&lt;</a>
						</li>
						<?php
						if ( !isset( $page ) )$page = 1;
						$page = intval( $page );
						$section = 8;
						$start = $page > $section ? $page - $section : 1;
						$end = $page + $section > $view_total_page ? $view_total_page : $page + $section;
						for ( $i = $start; $i <= $end; $i++ ) {
							echo "<li class='" . ( $page == $i ? "active " : "" ) . "page-item'>
        <a class='page-link' href='problemset.php?page=" . $i . "'>" . $i . "</a></li>";
						}
						?>
						<li class="page-item"><a class="page-link" href="problemset.php?page=<?php echo $view_total_page?>">&gt;&gt;</a>
						</li>
					</ul><?php } ?>
					</div>
					</div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4><?php echo $MSG_SEARCH;?></h4>
					<div class="row">
						<div colspan='1' class="col-md-12"><form action='problemset.php' class="form-search form-inline">
							        <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-search"></i></span>
        </div>
								<input type="text" name=search class="form-control search-query" style="display:inline;width:auto">
								</div>
							</form>
						</div>
					</div>
            </div>
        </div>
		<?php if ($THEME_SHOW_CATEGORY == true) { ?>
        <br>
        <div class="card">
            <div class="card-body">
                <h4><?php echo $MSG_SOURCE;?></h4>
				<?php $view_category="";
	$sql=	"select distinct source "
			."FROM `problem` where defunct='N'"
			."LIMIT 500";
	$result=pdo_query($sql);
	$category=array();
    foreach ($result as $row){
		$cate=explode(" ",$row['source']);
		foreach($cate as $cat){
			array_push($category,trim($cat));	
		}
	}
	$category=array_unique($category);
	if (!$result){
		$view_category= "No Category Now!";
	}else{
		foreach ($category as $cat){
			if(trim($cat)=="") continue;
			$hash_num=hexdec(substr(md5($cat),0,7));
			$label_theme=$color_theme[$hash_num%count($color_theme)];
			if($label_theme=="") $label_theme="default";
			$view_category.= "<a class='badge badge-$label_theme' href='problemset.php?search=".urlencode(htmlentities($cat,ENT_QUOTES,'UTF-8'))."'>".$cat."</a>&nbsp;";
		}
	}
	echo $view_category;
	?>
            </div>
        </div>
		<?php } ?>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
