<?php
/**	op-asset-template:/404.php
 *
 * @created    2025-10-16
 * @version    1.0
 * @package    op-asset-template
 * @author     Tomoaki Nagahara
 * @copyright  Tomoaki Nagahara All right reserved.
 */

/**	namespace
 *
 */
namespace OP;

//	Change http status code.
http_response_code(404);

//	...
if( OP()->isShell() ){
	$ext  = 'txt';
	$mime = 'text/plain';
}else{
	//	...
	require_once( _ROOT_CORE_.'/function/GetExtension.php' );
	require_once( _ROOT_CORE_.'/function/GetMimeFromExtension.php' );
	//	...
	$ext  = GetExtension($_SERVER['REQUEST_URI']);
	$mime = $ext ? GetMimeFromExtension($ext) : 'text/html';
}
$type = explode('/', $mime)[0];
$code = OP()->Request('code') ?? 'NotFound';
$args = [];
$layout = true;

//	...
switch( $type ){
	//	...
	case 'text':
		if( $ext === 'txt' ){
			$file = '404.txt';
		}else{
			$file = '404.phtml';
		}
		break;

		//	...
	case 'image':
		$mime = 'image/svg+xml';
		$file = '404.svg';
		$args = [
			'code'   => $code,
			'width'  => 200,
			'length' => 180,
		];
		$layout = false;
		break;

	default:
		if( OP()->isAdmin() ){
			OP()->Error("Does not support this mime type: {$mime}");
		}
}

//	Check layout template file exists.
$meta = 'asset:/layout/' . OP()->Unit()->Layout()->Name() . "/template/{$file}";
if(!file_exists( OP()->Path($meta) ) ){
	$meta = $file;
}

//	...
OP()->Unit()->Layout()->Execute( $layout );
OP()->MIME($mime);
OP()->Template($meta, $args);
