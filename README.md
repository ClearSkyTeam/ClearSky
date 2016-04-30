## Choose Language:   
####  [English](#ENG)
####  [Español](#SPA)  
####  [中国](#CHINESE_1)  
####  [日本語](#JAPANESE)
####  [Українська мова](#UKR)  

# <a name="ENG"></a>English  
# We present you: ClearSky-Sunrise ~ A [PM](https://github.com/PocketMine/PocketMine-MP) fork (PHP5) 
ClearSky is an ultra fast Minecraft: Pocket Edition server software with clean feels and stable features. It was initially designed for production servers.

**TravisCI Build Status** [![TravisCI](https://travis-ci.org/ClearSkyTeam/ClearSky.svg?branch=0.14.0)](https://travis-ci.org/ClearSkyTeam/ClearSky "TravisCI Build Status")
**Jenkins Build Status** [![Build Status](http://jenkins.clearskyteam.org/buildStatus/icon?job=ClearSky)](http://jenkins.clearskyteam.org/job/ClearSky/ "Jenkins Build Status")


 - We may take code from other GPL licenced projects, but most features are fully-rewritten for ClearSky.
 - Here is an Telegram group, where you can communicate with us: [Telegram/ClearSky] (https://telegram.me/joinchat/AlErxD3AN_GOgeSAcS0twA).
 - [Look here how fast ClearSky starts with 70 plugins and 20 worlds!](http://wolvesfortress.de/ezgif-1446650535.gif)
 - Inofficial Test Server : Creative IP: WolvesFortress.de Port: **19134** *Often offline, but if online, latest version*

## Where can I get a phar?
 - You can get an auto build phar here: [Jenkins CI](http://jenkins.clearskyteam.org/).
 - You can get an optimized PHP enviroment here: [ClearSkyTeam/PHPbinary](https://github.com/ClearSkyTeam/PHPbinary).
 - You can get a Multicraft config demo here: [ClearSkyTeam/MulticraftConfig](https://github.com/ClearSkyTeam/MulticraftConfig).

## Is there / will there be a PHP7 version?
 - Yes. But we planned to make features being stable first, then upgrading to PHP7

## [CRITICAL]: Please REMOVE xdebug in production server
 - You can comment out zend_extension=php_xdebug in your php.ini or recompile PHP without xdebug.
 - There is also a switch under debug in pocketmine.yml to force enable xdebug.

## Advanced Features
All features can be configed in pocketmine.yml.<br>
 - About 20 times faster than offical PM repo
 - Universal Client version join (e.g. 0.14.0 and builds for 0.14.0 can join together)(note¹)
 - Unlimited player join (set max-players to -1 in server.properties)(note²)
 - Modified Version color and string freely (set network.protocol,version in pocketmine.yml)
 - You can increase acceptable packetlost and disable anti-cheat when your server in a bad network (network section in pocketmine.yml) 
 - UltraFast Redstone Calculation with almost no bugs
 - Fully working Experience System, include block/player/entity/bottle/furnace hook.
 - Fully working Food & Hunger System, include game-difficulty hook.
 - Fully working Weather System
 - Fully working boats
 - Fast Chunk loading and sending
 - Fast Logger, includes a switch to turn log on/off
 - Almost perfect translations
 - Potions (Working, Creative Only)
 - Enchanting (Command)
 - Variations of Mobs (Rabbits, Villagers etc.)
 - Bug Fixes

Note¹ - Please set 'Outdated Server' message to 'false' in the CustomAlert plugin or any related plugin if you encounter *Outdated server*

Note² - Please set 'Full server' message to 'false' in the CustomAlert plugin or any related plugin if you encounter *Full server*

## For Developers
This is a clean, high quality code base, because we are trying to keep PocketMine's great code quality.
Developing/modifying this project is easy.<br>
We are still rewriting the base to make sure ClearSky has the best developing feel.<br>
ClearSky is not just for a CLEAN feel for users - it's also for developers!<br>

# <a name="SPA"></a>Español
# Te presentamos: ClearSky-Sunrise ~ Una Bifurcación (o Fork) de [PocketMine](https://github.com/PocketMine/PocketMine-MP) (PHP5) 
ClearSky es un software de servidor rapido para Minecraft: Pocket Edition limpio y con caracteristicas estables. Fue diseñado para los servidores de producción.

**Estado de la compilación deTravisCI** [![TravisCI](https://travis-ci.org/ClearSkyTeam/ClearSky.svg?branch=0.14.0)](https://travis-ci.org/ClearSkyTeam/ClearSky "TravisCI Build Status")
**Estado de la compilación de Jenkins** [![Build Status](http://jenkins.clearskyteam.org/buildStatus/icon?job=ClearSky)](http://jenkins.clearskyteam.org/job/ClearSky/ "Jenkins Build Status")


 - Tomamos codigo de otros proyectos pero la mayoria de las caracteristicas las reescribimos para ClearSky.
 - Nuestro grupo de Telegram, para que hables con nosotros: [Telegram/ClearSky] (https://telegram.me/joinchat/AlErxD3AN_GOgeSAcS0twA).
 - [Mira como ClearSky abre así de rapido con con 70 plugins y 20 mundos](http://wolvesfortress.de/ezgif-1446650535.gif)
 - Servidor de pruebas no oficial : IP: WolvesFortress.de Puerto: **19134** *A menudo fuera de línea, pero si lo esta posee la última versión de ClearSky.*

## Donde consigo una  (Phar)?
 - Consiguelo aqui: [Jenkins CI](http://jenkins.clearskyteam.org/).
 - Consigue un tiempo de ejecución de PHP optimizado: [ClearSkyTeam/PHPbinary](https://github.com/ClearSkyTeam/PHPbinary).
 - Consigue una prueba de Multicraft aqui: [ClearSkyTeam/MulticraftConfig](https://github.com/ClearSkyTeam/MulticraftConfig).

## Esta / Estará disponible una versión para PHP7?
 - Si, pero tenemos planeado hacer las características estables primero, luego actualizamos a PHP7.

## [CRITICO]: Por Favor Extrae xdebug del servidor de producción
 - Pon de comentario zend_extension=php_xdebug en tu php.ini o recompila PHP sin xdebug.
 - También hay un switch abajo en las opciones de depuración en pocketmine.yml para forzar el habilitamiento de xdebug.

## Caracteristicas Advanzadas
Todas las caracteristicas pueden ser configuradas en pocketmine.yml.<br>
 - Es alrededor 20 veces mas rapido que PocketMine!
 - Soporte universal de clientes (e.j. 0.14.0 y builds de 0.14.0 pueden entrar juntos)(nota¹)
 - Capacidad de jugadores ilimitada (pon max-players a -1 en server.properties)(nota²)
 - Color de la versión modificada libremente (cambia network.protocol, version en pocketmine.yml)
 - Puede aumentar la pérdida de paquetes aceptable y desactivar el anti-trampas cuando su servidor este en una red mala (Sección de red en pocketmine.yml) 
 - Calculación rápida de la Redstone sin fallas.
 - Sistema de Experiencia operativo, incluido en block/player/entity/bottle/furnace.
 - Sistema de comida y hambre funcional con soporte de intercambio de dificultad.
 - Clima operativo.
 - Barcas operativas.
 - Envio y recepción de Chunks rapida.
 - Registro rapido, switch incluido.
 - Traducciones casi perfectas
 - Pociones (Funcionan solo en creativo)
 - Encantamientos (Solo por comandos)
 - Variaciones de Mobs (Conejos, Aldeanos, etc.)
 - Correción de errores.

Nota¹ - Porfavor poner el mensaje 'Outdated Server' a 'false' en el plugin CustomAlert, o algun plugin parecido si se encuentra *Outdated Server* al entrar.

Nota² -Porfavor poner el mensaje 'Full Server' a 'false' en el plugin CustomAlert, o algun plugin parecido si se encuentra *FullServer* al entrar.
  		  
## Para desarrolladores
ClearSky es un software limpio, porque tratamos de conservar el codigo de alta calidad de PocketMine.<br>		 
Este es un codigo limpio, y de Alta Calidad. Desarrollar/modificar este proyecto es facil.<br>
Aun estamos reescribiendo la base para asegurar que ClearSky tenga la mejor sensación de desarrollo.<br>
ClearSky no tiene una sensación limpia solo para los Usuarios, Sino para los desarrolladores tambien!<br>

# <a name="CHINESE_1"></a>晴空
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
 - 通用客户端加入 (比如0.13.0 0.13.1 0.13.2可以在一起游戏)
 - 无限玩家数量 (将server.properties中的 max-players 设置为-1)
 - 你可以自定义显示的版本号及颜色 (pocketmine.yml 中 network 项下的 protocol 和 version 设置)
 - 兼容网络差的玩家，可以在network下关闭作弊检测 (anti-cheat)或者增大丢包允许率
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


# <a name="JAPANESE"></a>クリアスカイ
クリアスカイはコードが綺麗で、安定した機能を備えた超高速なMinecraft: Pocket Editionサーバーソフトウェアです。当初は商用サーバー用に設計されました。<br>
 - 他のGPLライセンスプロジェクトのコードを使用している部分もありますが、殆どはClearSkyによって書き換えられた物です。
 - ここで私たちとコミュニケーションを取ることができます: [Telegram/ClearSky] (https://telegram.me/joinchat/AlErxAY3tx0MPBGYuGtpDA)(英語)
[ClearSkyロビ] (https://lobi.co/invite/mKWL)(日本語)
 - [ここを見て 70個のプラグイン・20個のワールド と共に、早いClearSkyを始めましょう！(動画)](http://wolvesfortress.de/ezgif-1446650535.gif)
 - 公式テストサーバー: Creative (IP: WolvesFortress.de, Port: **19134**) *基本的にはオフラインですが、もしオンラインの場合は最新バージョンです。*

## どこで私はpharを手に入れれますか？
 - 自動でビルドされたphar: [Jenkins CI](http://jenkins.clearskyteam.org/).
 - 最適化されたPHP環境(bin): [ClearSkyTeam/PHPbinary](https://github.com/ClearSkyTeam/PHPbinary).
 - Multicraftの設定例: [ClearSkyTeam/MulticraftConfig](https://github.com/ClearSkyTeam/MulticraftConfig).

## [重要]: 本番ではXdebugを削除してください
 - bin/php/php.iniまたはbin/php5/bin/php.iniから"zend_extension=php_xdebug"をコメントアウトするか、Xdebug無しでPHPを再コンパイルしてください。
 - pocketmine.ymlで強制的にXdebugを有効にすることも出来ます。

## 高度な機能
全ての機能はpocketmine.ymlで設定することができます。<br>
 - 公式PocketMine-MPよりも20倍早く動きます
 - 複数のバージョンに同時に対応 (例えば、0.14.0でビルドを行ったら、0.14.1, 0.14.2などでも一緒に入れます。)(脚注1)
 - プレイヤー数を無制限に (server.propertiesの"max-players"を"-1"にしてください。)(脚注2)
 - バージョンの色と文字を自由に変更できます。 (pocketmine.ymlの"network.protocol"を変更してください。)
 - 通信環境が悪いネットワークでも、パケットロスの許容数を増やせてチート対策が行えます。
 - 全くバグのない高速なレッドストーン
 - 完全な経験値システム。ブロック/プレイヤー/エンティティ/ボトル/かまど に対応しています。
 - 完全な空腹システム。ゲームの難易度のフックが含まれています。
 - 完全な天候システム。
 - 完全に動くボート。
 - 高速なチャンクの読み込み・送信
 - 高速なログ記録。ログのオン/オフの切り替えを含みます。
 - ほぼ完璧な翻訳。
 - ポーション (クリエイティブのみ)
 - エンチャント (コマンドのみ)
 - Mobのバリエーション (うさぎ、村人、などなど...)
 - バグの修正

脚注1: "Outdated Server"のメッセージが表示された場合、CustomAlertプラグインなどで無効化してください。

脚注2: "Full server"のメッセージが表示された場合、CustomAlertプラグインなどで無効化してください。

## 開発者へ
これはきれいな、高品質のコードベースです。開発/修正がこのプロジェクトは簡単です。<br>
私たちは最良な開発状況を保てるよう、常にコードを書き換えています。<br>
クリアスカイは単にユーザーのために高品質なのではなく、開発者の為にもです！<br>


# <a name="UKR"></a>Українська мова
ClearSky є ультра-швидким програмним забезпеченням для сервера Minecraft: Pocket Edition з багатьма можливостями.
 - Ми можемо брати код з інших GPL ліцензованих проектів, але більшість функцій були повністю перероблені для ClearSky.
 - Це наша Telegram група, де ви можете спілкуватися з нами: [Telegram/ClearSky] (https://telegram.me/joinchat/AlErxAY3tx0MPBGYuGtpDA).
 - [Подивіться тут, як швидко стартує ClearSky використовуючи 70 плагінів і 20 світів!](http://wolvesfortress.de/ezgif-1446650535.gif)
 - Неофіційний тестовий сервер: Creative IP: WolvesFortress.de Port: **19133** *Часто офлайн, але коли онлайн, то найновіша версія*

## Де я можу отримати phar?
 - **Перед першим запуском або оновленням ClearSky видаліть pocketmine.yml для оновленя налаштувань.**
 - Ви можете отримати авто-генерований phar тут: [Jenkins CI](http://jenkins.clearskyteam.org/).
 - Ви можете отримати PHP каталог тут: [ClearSkyTeam/PHPbinary](https://github.com/ClearSkyTeam/PHPbinary).
 - Ви можете отримати демо версію конфігурації для Multicraft тут: [ClearSkyTeam/MulticraftConfig](https://github.com/ClearSkyTeam/MulticraftConfig).

## [ВАЖЛИВО]: Будь ласка ВИМКНІТЬ xdebug 
 - Ви можете встановити параметр zend_extension=php_xdebug у php.ini або переробити PHP без xdebug.
 - Також є функція в pocketmine.yml щоб примусово ввімкнути xdebug.

## Особливості
Усі можливості та функції можуть бути переконфігуровані у pocketmine.yml.<br>
 - ClearSky є понад 20 разів швидший ніж офіційна PM репозиторія
 - Універсальні клієнти можуть грати на сервері (тобто 0.14.0 і всі його білди можуть грати разом)(примітка¹)
 - Безлімітні слоти для гравців (установіть параметр max-players на -1 в server.properties)(примітка²)
 - Модифікований колір версії (установіть параметр network.protocol,version у pocketmine.yml)
 - Ви можете налаштувати packetlost і вимкнути anti-cheat коли у вас погане з'єднання з мережею (розділ network в pocketmine.yml) 
 - Ультра-швидка калькуляція редстоуну майже без багів
 - Повністю робоча система досвіду, включаючи: блоки/гравець/створіння/зілля/піч.
 - Повністю робоча система їди та голоду, включаючи налаштування складності гри.
 - Повністю робоча система погоди
 - Робочі човни (плавають)
 - Швидкий обмін чанками
 - Швидка система логування, включаючи увімкнення або вимкнення запису до файлу
 - Досконалі переклади
 - Зілля (Працюють, тільки в режимі творчості)
 - Чарування (Командою)
 - Моби
 - Фікс багів

Примітка¹ - Установіть параметр 'Outdated Server' на 'false' в плагіні CustomAlert

Примітка² - Установіть параметр 'Full server' на 'false' в плагіні CustomAlert

## Для Розробників
ClearSky - це досконала, високоякісна база коду. Створення/модифікування цього проекту є легким.<br>
Ми продовжуємо переписувати код, щоб впевнитися, що ClearSky є найкращим.<br>
ClearSky призначений не тільки для звичайних кориcтувачів - він також для розробників!<br>
