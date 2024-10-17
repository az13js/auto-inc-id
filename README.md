# 自增ID生成和获取工具

1. [Click here to view the English version of the README](README.en.md)
2. [点击这里查看中文版本的README](README.md)

PHP实现单机获取自增ID功能。使用方法：

一，先通过Composer安装源码：

```sh
composer require "az13js/auto-inc-id"
```

二，在代码中引入：

```php
require __DIR__ . '/vendor/autoload.php';
```

三，使用：

```php
// 获取自增ID（优先通过共享内存获取自增ID，如果没有则从环境变量AUTO_INC_ID_FILE设置的文件中获取自增ID）
echo 'get_auto_inc_id():' . PHP_EOL;
echo get_auto_inc_id() . PHP_EOL;

// 直接通过共享内存获取自增ID
echo 'get_auto_inc_id_shm():' . PHP_EOL;
echo get_auto_inc_id_shm() . PHP_EOL;

// 直接通过环境变量AUTO_INC_ID_FILE设置的文件中获取自增ID
echo 'get_auto_inc_id_file():' . PHP_EOL;
echo get_auto_inc_id_file() . PHP_EOL;
```

注意事项：

- 环境变量AUTO_INC_ID_FILE用于从文件中获取自增ID，如果没有，尝试通过文件获取将会失败
- 获取自增ID的函数在失败时会返回`false`，不会抛出异常
- 配置环境变量AUTO_INC_ID_DEBUG的值为任意布尔值为真的值时，开启调试模式，会通过标准错误输出调试信息
