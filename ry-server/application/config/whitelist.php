<?php
//白名单
//在白名单内的url无需登录校验
$whiteList['sys_user']['login'] = 1;
$whiteList['sys_user']['logout'] = 1;
$whiteList['verify_code']['index'] = 1;