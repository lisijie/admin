# admin
PHP后台模板。

* 前端框架使用ACE (https://github.com/bopoda/ace)
* php框架 (https://github.com/lisijie/php-framework.git)

### 使用说明：

	$ git clone https://github.com/lisijie/admin.git
	$ cd admin
	$ composer install
	

创建数据库，修改 app/Config/app.php 下的数据库配置。最后导入 install.sql 到数据库。

对ace前端框架不熟悉的话，可以把它克隆到本地，参照里面的各个示例制作模板文件。