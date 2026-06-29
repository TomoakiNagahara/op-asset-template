<?php
/**	op-asset-template:/translation.php
 *
 * @created    2026-06-29
 * @license    Apache-2.0
 * @package    op-asset-template
 * @copyright  Tomoaki Nagahara
 */

/**	namespace
 *
 */
namespace OP;

//	WebPack
OP()->Unit()->WebPack()->Auto(
	'asset:/webpack/js/Translator.js',
	'asset:/webpack/js/Translate_Language.js',
	'asset:/webpack/css/color.css',
	'asset:/webpack/css/Translate_Language.css',
);
