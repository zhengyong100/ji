# -PHP-
修改自zhengyong100的记账程序，对文件名进行优化。 原作：https://github.com/zhengyong100/ji

使用方法：

1.首先修改config.php内的前9行，修改为你的配置，stmp邮箱请使用163邮箱。

2.访问install.php进行安装。

Demo：http://salitt.com/site/account

更新日志：

2017/06/02

1.增加日期时间选择器

2017/05/17

1.数据库表前缀可全局定义

2.自动为新注册用户添加默认分类

3.登录和注销优化，index.php主页可判断是否已登录并跳转页面，注销可正确地注销。

4.修复无法清空全部数据

5.优化判断逻辑、删除原来的login.php并用index.php代替。

6.支持2位小数金额.

7.修复add.php手动刷新重复提交数据
