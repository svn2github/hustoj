# LiveCD 解析

### LiveCD 的实现

通过 `uck` 工具解压出 `Ubuntu LiveCD` 的 `chroot` 环境，并在其中删除 `oo` 、 `gnome` 等大型程序释放空间，然后用 `apt` 工具安装基础环境，安装配置 `lxde` 和 `hustoj` 。再使用 `uck` 重新打包形成 `iso`。

### 升级方式

利用 `Github` 的 SVN 服务，用 SVN 客户端分别升级 `core` 和 `web` ,再编译 `core` ，并通过 `web` 提供可能的数据库升级。

`LiveCD` 中的升级脚本为 `update-hustoj` ，可以用 `which` 命令查找其实际位置。
