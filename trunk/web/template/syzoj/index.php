<?php $show_title="首页 - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>
<div class="padding">
    <div class="ui three column grid">
        <div class="eleven wide column">
            <h4 class="ui top attached block header"><i class="ui info icon"></i>公告</h4>
            <div class="ui bottom attached segment">
                <table class="ui very basic table">
                    <thead>
                        <tr>
                            <th>标题</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_news = "select * FROM `news` WHERE `defunct`!='Y' AND `title`!='faqs.cn' ORDER BY `importance` ASC,`time` DESC LIMIT 10";
                        $result_news = mysql_query_cache( $sql_news );
                        if ( $result_news ) {
                            foreach ( $result_news as $row ) {
                                echo "<tr>"."<td>"
                                    ."<a href=\"viewnews.php?id=".$row["news_id"]."\">"
                                    .$row["title"]."</a></td>"
                                    ."<td>".$row["time"]."</td>"."</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h4 class="ui top attached block header"><i class="ui signal icon"></i>排名</h4>
            <div class="ui bottom attached segment">
                <table class="ui very basic center aligned table" style="table-layout: fixed; ">
                    <thead>
                        <tr>
                            <th style="width: 50px; ">#</th>
                            <th style="width: 170px; ">用户名</th>
                            <th>个性签名</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql_users = "select * FROM `users` ORDER BY `solved` DESC LIMIT 15";
                        $result_users = mysql_query_cache( $sql_users );
                        if ( $result_users ) {
                            $i = 1;
                            foreach ( $result_users as $row ) {
                                echo "<tr>"."<td>".$i++."</td>"."<td>"
                                    ."<a href=\"userinfo.php?user=".$row["user_id"]."\">"
                                    .$row["user_id"]."</a></td>"
                                    ."<td>".$row["school"]."</td>"."</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="right floated five wide column">
            <h4 class="ui top attached block header"><i class="ui rss icon"></i>最近更新</h4>
            <div class="ui bottom attached segment">
                <table class="ui very basic center aligned table">
                    <thead>
                        <tr>
                            <th width="70%">题目</th>
                            <th width="30%">更新时间</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql_problems = "select * FROM `problem` ORDER BY `problem_id` DESC LIMIT 5";
                        $result_problems = mysql_query_cache( $sql_problems );
                        if ( $result_problems ) {
                            $i = 1;
                            foreach ( $result_problems as $row ) {
                                echo "<tr>"."<td>"
                                    ."<a href=\"problem.php?id=".$row["problem_id"]."\">"
                                    .$row["title"]."</a></td>"
                                    ."<td>".$row["in_date"]."</td>"."</tr>";
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <h4 class="ui top attached block header"><i class="ui search icon"></i>题目跳转</h4>
            <div class="ui bottom attached segment">
                <form action="problem.php" method="get">
                    <div class="ui search" style="width: 100%; ">
                        <div class="ui left icon input" style="width: 100%; ">
                            <input class="prompt" style="width: 100%; " type="text" placeholder="题目号 …" name="id">
                            <i class="search icon"></i>
                        </div>
                        <div class="results" style="width: 100%; "></div>
                    </div>
                </form>
            </div>
            <h4 class="ui top attached block header"><i class="ui calendar icon"></i>近期比赛</h4>
            <div class="ui bottom attached center aligned segment">
                <table class="ui very basic center aligned table">
                    <thead>
                        <tr>
                            <th>比赛名称</th>
                            <th>开始时间</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql_contests = "select * FROM `contest` ORDER BY `contest_id` DESC LIMIT 5";
                        $result_contests = mysql_query_cache( $sql_contests );
                        if ( $result_contests ) {
                            $i = 1;
                            foreach ( $result_contests as $row ) {
                                echo "<tr>"."<td>"
                                    ."<a href=\"contest.php?cid=".$row["contest_id"]."\">"
                                    .$row["title"]."</a></td>"
                                    ."<td>".$row["start_time"]."</td>"."</tr>";
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include("template/$OJ_TEMPLATE/footer.php");?>
