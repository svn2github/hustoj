# 结构简析

### 概述

HUSTOJ 分为两大部分，`core` 和 `web` ，分别对应判题和数据管理两大功能。

`core` 和 `web` 之间数据交换有两种方式：

1、通过数据库，轮询。
2、通过 `wget` 实现的 `HTTP` 请求。

两种方式的选择在判题端的配置文件 `/home/judge/etc/judge.conf` 中， `HTTP_JUDGE=1` 则启用后者，默认为前者。

### 分类

- [Core 解析](/Composition-Core)
- [Web 解析](/Composition-web)
- [Core 与 Web 的连接方式解析](/Composition_Client)
- [数据库解析](/Composition-Database)
- [LiveCD 解析](/Composition-LiveCD)
