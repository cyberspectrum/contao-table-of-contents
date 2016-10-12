<?php

/**
 * This file is part of cyberspectrum/contao-table-of-contents.
 *
 * (c) 2016 CyberSpectrum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    TableOfContents
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright  2016 CyberSpectrum.
 * @license    https://github.com/cyberspectrum/contao-table-of-contents/blob/master/LICENSE LGPL-3.0
 * @filesource
 */

error_reporting(E_ALL);

function includeIfExists($file)
{
    return file_exists($file) ? include $file : false;
}

if (
    // Locally installed dependencies
    (!$loader = includeIfExists(__DIR__.'/../vendor/autoload.php'))
    // We are within an composer install.
    && (!$loader = includeIfExists(__DIR__.'/../../../autoload.php'))) {
    echo 'You must set up the project dependencies, run the following commands:'.PHP_EOL.
        'curl -sS https://getcomposer.org/installer | php'.PHP_EOL.
        'php composer.phar install'.PHP_EOL;
    exit(1);
}

define('TL_ROOT', __DIR__ . '/../vendor/contao/core');
require_once __DIR__ . '/../vendor/contao/core/system/helper/functions.php';

$GLOBALS['TL_CONFIG']['characterSet'] = 'utf-8';

// Contao autoload hack.
spl_autoload_register(function ($class) {
    if (strncmp($class, 'Contao\\', 7) === 0) {
        return;
    }

    if (class_exists('Contao\\' . $class)) {
        class_alias('Contao\\' . $class, $class);
    }
});
