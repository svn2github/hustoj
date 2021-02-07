<!DOCTYPE html>
<html lang="cn">

<head>
    <?php include('_includes/head.php'); ?>
</head>

<body class="mdui-drawer-body-left mdui-theme-primary-indigo mdui-theme-accent-indigo mdui-appbar-with-toolbar">
    <?php include('_includes/header.php'); ?>
    <?php include('_includes/sidebar.php'); ?>
    <div class="mdui-container">
        <h1>分类</h1>
        <?php if(!$result) { ?>
            <div style="font-size: 175%;">暂无分类</div>
        <?php } else { ?>
            <?php
                $colors = [
                    "red",
                    "pink",
                    "purple",
                    "orange",
                    "light-blue",
                    "green",
                    "teal"
                    ];
                foreach($result as $row) { 
                    $hash_num = hexdec(substr(md5($row["source"]),0,7));
                    $label_color = $colors[$hash_num%count($colors)];
                    $label_color = $label_color ? $label_color : "theme";
                    if($row["source"]) {
                        echo '<a class="mdui-btn mdui-btn-dense mdui-color-'.$label_color.'-accent mdui-ripple mdui-m-a-2" href="problemset.php?search='.urlencode($row["source"]).'">'.$row["source"].'</a>';
                    }
                }
            ?>
        <?php } ?>
    </div>
</body>

</html>
