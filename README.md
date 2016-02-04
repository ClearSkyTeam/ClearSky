# ClearSky-Blue[![TravisCI](https://travis-ci.org/ClearSkyTeam/ClearSky.svg?branch=master)](https://travis-ci.org/ClearSkyTeam/ClearSky)
ClearSky is an ultra fast Minecraft: Pocket Edition server software with clean feels and stable features. It was initially designed for production servers.
 - We may take code from other GPL licenced projects, but most features are fully-rewritten for ClearSky.
 - Our communicate group is online now. Join us here: [Telegram/ClearSky](https://telegram.me/joinchat/AlErxAY3tx0MPBGYuGtpDA)

## Where can I get a phar?
 - **Before you launch ClearSky please remove pocketmine.yml once to update.**
 - You can get an auto build phar here: [Jenkins CI](http://jenkins.clearskyteam.org/).
 - You can get an optimized PHP enviroment here: [ClearSkyTeam/PHPbinary](https://github.com/ClearSkyTeam/PHPbinary).
 - You can get a Multicraft config demo here: [ClearSkyTeam/MulticraftConfig](https://github.com/ClearSkyTeam/MulticraftConfig).

## [CRITICAL]: Please REMOVE xdebug in production server
 - You can comment out zend_extension=php_xdebug in your php.ini or recompile PHP without xdebug.
 - There is also a switch under debug in pocketmine.yml to force enable xdebug.

## Advanced Features
All features can be configed in pocketmine.yml.<br>
 - About 20 times faster than offical PM repo.
 - UltraFast Redstone Calculation with lots of logic.
 - Fully working Experience System, include block/player/entity/bottle/furnace hook.
 - Fully working Food & Hunger System, include game-difficulty hook.
 - Fully working Weather System.
 - Fast Chunk loading and sending
 - Fast Logger, includes a switch to turn log on/off
 - Potions (Working, Creative Only)
 - Enchanting (Command)
 - Bug Fixes

## For Developers
This is a clean, high quality code base. Developing/modifying this project is easy.<br>
We are still working on a clean rewritten base to make sure ClearSky has the best developing feel.<br>
ClearSky is not just for a CLEAN feel for users - it's also for developers!<br>

# 晴空
一个为应用服务器设计的高性能MinecraftPE服务端软件
 - 我们可能从其他GPL许可的项目中获取源码，但是绝大多数已经在被整合到晴空之前被复刻（这意味着它与其他的项目/源码是不同的）。

## 在哪里可以下载到打包好的phar?
 - **注意：在运行晴空之前，请删除pocketmine.yml以便于晴空优化您的配置**
 - 你可以在这里获取一个自动打包的phar: [Jenkins CI](http://jenkins.clearskyteam.org/).
 - 你可以在这里获取一个优化的PHP运行环境: [ClearSkyTeam/PHPbinary](https://github.com/ClearSkyTeam/PHPbinary).
 - 你可以在这里获得一个Multicraft配置文件样例: [ClearSkyTeam/MulticraftConfig](https://github.com/ClearSkyTeam/MulticraftConfig).

## [CRITICAL]: Please REMOVE xdebug in production server
 - 如果你在启动服务端时出现了上述警告，解决方法如下
 - 你可以将bin目录下php.ini中 zend_extension=php_xdebug 一行注释掉或删除.
 - 如果你是需要调试功能，可以开启pocketmine.yml中debug区域下的allow-xdebug项.

## 高级功能
所有的功能都可以在 pocketmine.yml 中设置.<br>
 - 较之PM官方项目，晴空有近20倍的性能提升.
 - 高效且有逻辑的红石系统.
 - 完整的经验系统 , 包括 挖掘/玩家/生物/附魔瓶/熔炉 事件.
 - 完整的食物 和 饥饿系统 ， 可以根据游戏难度自动适配.
 - 完整的天气系统 .
 - 高速区块加载及传送 .
 - 高速日志系统，你也可以完全关闭日志 .
 - 药水(有效果，创造模式获取)
 - 附魔(仅限指令)
 - 修正诸多BUG

## 致开发者
这是一个干净，高效的PocketMine-MP的重制，你可以在这里获得最佳的开发体验.<br>
我们仍然在不断地重写代码保证其高效性以及易读性.<br>
晴空不仅仅是用起来干净，对于开发者来说也是一片艳阳天!<br>
