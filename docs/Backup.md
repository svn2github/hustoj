# 备份与还原

## 备份

脚本安装的用户，可以使用 `install` 目录中的 `bak.sh` 进行备份。

```bash
sudo bash /home/judge/src/install/bak.sh
```

备份后的数据在 `/var/backups/`

百度学习 `crontab` 的用法后，可以使用 `sudo crontab -e` 定制自动备份计划，部分安装脚本中包含了自动备份，但可能需要运行上面的语句一次来激活。

## 还原

如果你需要进行跨系统迁移（如从 `Ubuntu` 迁移到 `CentOS`），可以尝试使用下面的脚本进行备份

```bash
sudo bash /home/judge/src/install/backup+.sh
```

备份后的归档在 `/home/judge/backup` ，命名格式为 `%Y-%m-%d-%H-%M-%S`

将你需要迁移的归档复制到目标系统的 `/home/judge/backup` 目录下，执行下面的脚本进行恢复

```bash
sudo bash /home/judge/src/install/restore+.sh
```

脚本的第一个参数为恢复的目标归档，如果没有参数则默认为按名字排序后字典序最大的归档。