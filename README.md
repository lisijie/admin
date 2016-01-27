# admin
基于我的PHP框架的后台模板。

* PHP框架 (https://github.com/lisijie/php-framework)

* 前端框架使用ACE (https://github.com/bopoda/ace)

### 使用说明：

先克隆php框架

	git clone https://github.com/lisijie/php-framework.git
	
再克隆后台模块

	git clone https://github.com/lisijie/admin.git
	
编辑 `admin/public/index.php` 文件，修改 App.php 路径为框架目录下的 system/App.php

创建数据库，修改 admin/app/Config/app.php 下的数据库配置。最后导入 admin/sql/install.sql 到数据库。

对ace前端框架不熟悉的话，可以把它克隆到本地，参照里面的各个示例制作模板文件。