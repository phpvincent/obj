<?php

return [
    /**
     * Workerman是一款纯PHP开发的开源高性能的PHP socket 服务框架
     * 主要统一配置不同的workman协成之间的域名，端口等全局信息
     */
    'http_service_ip' => env("HTTP_SERVICE_URL","13.229.73.221:2351"),
];
