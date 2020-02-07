<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>一言 - MasterOJ</title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="card" style="margin: 3% 8% 5% 8%">
  <div class="card-body">
    <h4>一言</h4>
    <p>
					    目录：<a href="#part1">一言介绍</a>&nbsp;&nbsp;<a href="#part2">新的一言</a>&nbsp;&nbsp;<a href="#part3">我的一言</a>&nbsp;&nbsp;<a href="#part4">API接入</a>
					</p>
					<p id="part1">
					    <h5>1、一言介绍</h5>
					    动漫也好、小说也好、网络也好，不论在哪里，我们总会看到有那么一两个句子能穿透你的心。我们把这些句子汇聚起来，形成一言网络，以传递更多的感动。<br>
					    简单来说，一言指的就是一句话，可以是动漫中的台词，也可以是网络上的各种小段子。<br>
或是感动，或是开心，有或是单纯的回忆。来到这里，留下你所喜欢的那一句句话，与大家分享，这就是一言存在的目的。<br>
                        <span style="color:#ccc">选自：https://hitokoto.cn/api</span>
					</p>
					<p id="part2">
					    <h5>2、新的一言</h5>
					    <form action="new_yiyan.php" method="post" role="form"><?php require_once('./include/set_post_key.php');?>
					        <p>
          <label style="width:120px">一言内容: </label>
          <textarea name="message" class="form-control" style="width:60%;height:100px"></textarea>
        </p>
					        <p>
          <label style="width:120px">一言出处/作者: </label>
          <input name="source" class="form-control" type="text" required>
        </p>
        <p>
          <label style="width:120px">一言类型: </label>
          <select name="type" class="form-control">
              <option value='a'>动画</option>
              <option value='b'>漫画</option>
              <option value='c'>游戏</option>
              <option value='d'>小说</option>
              <option value='e'>原创</option>
              <option value='f'>来自网络</option>
              <option value='g'>其他</option>
          </select>
        </p>
        <button class="btn btn-outline-primary" type="submit">提交</button>
        <p>
        或者从Hitokoto导入.粘贴https://v1.hitokoto.cn/复制的代码，完成导入</p>
					    </form>
					    <form action="new_yiyan_json.php" method="post" role="form">
					    <p>
          <label style="width:120px">json代码: </label>
          <textarea name="hitokoto" class="form-control" style="width:60%;height:100px"></textarea>
        </p>
        <button class="btn btn-outline-info" type="submit">提交</button>
					    </form>
					</p>
					<p id="part3">
					    <h5>3、我的一言</h5>
					    <table style="font-weight: 400;border:none;" class="table table-hover">
					        <thead class="phead">
					            <tr>
					                <th width=4%>id</th>
					                <th>内容</th>
					                <th width=10%>来源/作者</th>
					                <th width=5%>类型</th>
					                <th width=15%>上传时间</th>
					            </tr>
					        </thead>
					        <tbody>
					            <?php 
					            $sql = "SELECT * FROM `onesay` WHERE `author`=?";
					            $resfm = pdo_query($sql, $_SESSION[$OJ_NAME.'_'.'user_id']);
					            foreach($resfm as $smdsf) {
					                echo "<tr>";
					                echo "<td>{$smdsf['id']}</td>";
					                echo "<td>{$smdsf['message']}</td>";
					                echo "<td>{$smdsf['source']}</td>";
					                echo "<td>{$smdsf['type']}</td>";
					                echo "<td>".date("Y-m-d",$smdsf['time'])."</td>";
					                echo "</tr>";
					            }
					            ?>
					        </tbody>
					    </table>
					</p>
					<p id="part4">
					    <h5>4、API接入</h5>
					    详情 <a href="api">MasterOJ API</a><br>
					    <b>4.1、请求地址</b><br>
					    <a href="http://masteroj.hustoj.com/api/yiyan.php">http://masteroj.hustoj.com/api/yiyan.php</a><br>
					    <b>4.2、请求参数</b><br>
					    (可选)type : 一言的类型<br>
					    a	Anime - 动画<br>
b	Comic – 漫画<br>
c	Game – 游戏<br>
d	Novel – 小说<br>
e	Myself – 原创<br>
f	Internet – 来自网络<br>
g	Other – 其他<br><b>4.3、返回</b><br>
json格式。<br>
id	本条一言的id。<br>
message	一言正文。编码方式unicode。<br>
type	类型。请参考第三节参数的表格。<br>
from	一言的出处。<br>
creator	添加者。<br>
created_at	添加时间(时间戳)。<br>
					</p>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
