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

namespace CyberSpectrum\TableOfContents\TableRenderer;

/**
 * This interface describes a table of contents renderer.
 */
interface TableRendererInterface
{
    /**
     * Render the passed link list.
     *
     * @param string[] $linkList The link list as hash => label.
     *
     * @return string
     */
    public function render($linkList);
}
