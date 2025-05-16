<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class PreventDirectAccess
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    // Đặt $proxies là '*' để tin tưởng tất cả các proxy.
    // Điều này thường an toàn trên các nền tảng PaaS như Railway.
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    // Đảm bảo bạn có ít nhất HEADER_X_FORWARDED_PROTO
    // Bạn có thể copy nguyên khối này.
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO | // Header này báo cho Laravel biết schema gốc là HTTPS
        Request::HEADER_X_FORWARDED_AWS_ELB; // Có thể hữu ích nếu Railway dùng AWS ELB (Amazon Web Services Elastic Load Balancer)
}
