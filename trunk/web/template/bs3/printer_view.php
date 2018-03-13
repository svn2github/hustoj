<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo htmlentities(str_replace("\n\r","\n",$view_user),ENT_QUOTES,"utf-8")?></title>  
</head>
<body>

<?php
echo "<h1>".htmlentities(str_replace("\n\r","\n",$view_user),ENT_QUOTES,"utf-8")."\n"."</h1>";
echo "<pre>".htmlentities(str_replace("\n\r","\n",$view_content),ENT_QUOTES,"utf-8")."\n"."</pre>";
?>
<input onclick="window.print();" type="button" value="<?php echo $MSG_PRINTER?>">
<input onclick="location.href='printer.php?id=<?php echo $id?>';" type="button" value="<?php echo $MSG_PRINT_DONE?>">
</script>
</body>
