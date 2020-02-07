## BShark主题后台

请在web目录下添加`404.html`，在用户无权限访时将自动显示404（浏览器地址不变）

如果您的数据库结构适应MasterOJ的数据库，则可以开启全部内容。

数据表差异

- contest中有type字段，用于记录是ACM竞赛还是OI竞赛

- users中score，qq，suffix，codeshare，hb，backimg，mailok，headtitle分别记录积分，qq，？？？，代码分享（新），壕币，是否完成邮箱验证，头衔

- activity记录活动，mailcheck用于邮箱验证
