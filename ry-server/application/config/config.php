<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
define('ENVIRONMENT', 'development');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

/**
 * Configuration for: URL
 * Here we auto-detect your applications URL and the potential sub-folder. Works perfectly on most servers and in local
 * development environments (like WAMP, MAMP, etc.). Don't touch this unless you know what you do.
 *
 * URL_PUBLIC_FOLDER:
 * The folder that is visible to public, users will only have access to that folder so nobody can have a look into
 * "/application" or other folder inside your application or call any other .php file than index.php inside "/public".
 *
 * URL_PROTOCOL:
 * The protocol. Don't change unless you know exactly what you do. This defines the protocol part of the URL, in older
 * versions of MINI it was 'http://' for normal HTTP and 'https://' if you have a HTTPS site for sure. Now the
 * protocol-independent '//' is used, which auto-recognized the protocol.
 *
 * URL_DOMAIN:
 * The domain. Don't change unless you know exactly what you do.
 *
 * URL_SUB_FOLDER:
 * The sub-folder. Leave it like it is, even if you don't use a sub-folder (then this will be just "/").
 *
 * URL:
 * The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
 * then replace this line with full URL (and sub-folder) and a trailing slash.
 */

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);



	/**
	 * 数据权限
	 * 全部
	 */
    define('_DATA_SCOPE_ALL', 1);    

	/**
	 * 数据权限
	 * 本单位及以下
	 */
    define('_DATA_SCOPE_DEPT_AND_CHILD', 2);     

	/**
	 * 数据权限
	 * 本单位
	 */
    define('_DATA_SCOPE_DEPT', 3); 

	/**
	 * 数据权限
	 * 自己
	 */
    define('_DATA_SCOPE_SELF', 4); 

	/**
	 * session超时时间
	 * 默认30秒
	 */
	define('SESSION_TIME',1800);

	/**
	 * 成功
	 */
	define('SUCCESS',0);

	/**
	 * 失败
	 */
	define('FAILURE',1);

	/**
	 * 操作类型
	 * 其它
	 */
	define('OPERATE_TYPE_OTHER',0);

	/**
	 * 操作类型
	 * 新增
	 */
	define('OPERATE_TYPE_ADD',1);

	/**
	 * 操作类型
	 * 修改
	 */
	define('OPERATE_TYPE_MODIFY',2);	

	/**
	 * 操作类型
	 * 删除
	 */
	define('OPERATE_TYPE_DELETE',3);	

	/**
	 * 文件上传路径
	 */
	define('UPLOAD_PATH',"upload");	

	/**
	 * JWT密钥
	 */
	define('JWT_SERCRET',"ryphpGpkVBR9TMcm");		