一个收集图片并打包的工具，主要用于完成上级团委组织的行政任务：收集青年大学习截图。

Work 的核心目的是略过技术，设计出一个功能简单易用兼容移动设备的工具。而经过一年的场景验证与投产改进，对服务器性能的需求足以忽略不计。

需要注意的是，图片附件会在客户端执行有损压缩。

### 安装 ###

安装 PHP 依赖：

    composer install

安装 Node.js 依赖：

    npm install
    npm run production

配置 `.env` 文件中的数据库信息：

    cp .env.example .env

    php artisan key:generate
    
执行数据库迁移。

    php artisan migrate
    
将 Web 服务器运行目录设为 `public`，并配置 Web 服务器的伪静态 [Pretty URLs - Installation Laravel](https://laravel.com/docs/master/installation#pretty-urls)。

### 维护 ###

项目中的导出功能由 Laravel 的 `deleteFileAfterSend` 方法提供，该方法在特定的情况下客户端下载文件后不会自动清理文件。

可以将这条命令根据需求修改后配置到 Cron 以自动清理压缩包。

    rm -rf storage/*.zip

如果项目中的数据不再需要，可以清理项目中的所有数据。

    rm -rf storage/app/*
    
    php artisan migrate:refresh
