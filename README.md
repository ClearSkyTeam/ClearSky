# ClearSky[![TravisCI](https://travis-ci.org/ClearSkyTeam/ClearSky.svg?branch=master)](https://travis-ci.org/ClearSkyTeam/ClearSky)
ClearSky is an ultra fast Minecraft: Pocket Edition server software with clean feels and stable features. It was initially designed for production servers.
 - We may take code from other GPL licenced projects, but most features are fully-rewritten for ClearSky.

## Where can I get a phar?
 - **Before you launch ClearSky please remove pocketmine.yml once to update.**
 - You can get a tested phar here: [ClearSkyTeam/ClearSky-Release](https://github.com/ClearSkyTeam/ClearSky-Release).

## [CRITICAL]: Please REMOVE xdebug in production server
 - You can comment out zend_extension=php_xdebug in your php.ini or recompile PHP without xdebug.
 - There is also a switch under debug in pocketmine.yml to force enable xdebug.

## Advanced Settings
You can find many useful new settings in pocketmine.yml.<br>
For example: Redstone, weather, experience and hunger.

## For Developers
This is a clean, high quality code base. Developing/modifying this project is easy.<br>
We are still working on a clean rewritten base to make sure ClearSky has the best developing feel.<br>
ClearSky is not just for a CLEAN feel for users - it's also for developers!<br>

# 晴空
一个为应用服务器设计的高性能MinecraftPE服务端软件
 - 我们可能从其他GPL许可的项目中获取源码，但是绝大多数已经在被整合到晴空之前被复刻（这意味着它与其他的项目/源码是不同的）。

## 在哪里可以下载到打包好的phar?
 - **注意：在运行晴空之前，请删除pocketmine.yml以便于晴空优化您的配置**
 - 请在这里获得phar: [ClearSkyTeam/ClearSky-Release](https://github.com/ClearSkyTeam/ClearSky-Release).

## [CRITICAL]: Please REMOVE xdebug in production server
 - 如果你在启动服务端时出现了上述警告，解决方法如下
 - 你可以将bin目录下php.ini中 zend_extension=php_xdebug 一行注释掉或删除.
 - 如果你是需要调试功能，可以开启pocketmine.yml中debug区域下的allow-xdebug项.

## 高级设置
你可以在 pocketmine.yml 中设置更多的功能.<br>
例如: 红石，天气，经验，饥饿，日志记录，以及调试.

## 致开发者
这是一个干净，高效的PocketMine-MP的重制，你可以在这里获得最佳的开发体验.<br>
我们仍然在不断地重写代码保证其高效性以及易读性.<br>
晴空不仅仅是用起来干净，对于开发者来说也是一片艳阳天!<br>
