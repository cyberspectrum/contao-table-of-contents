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

namespace CyberSpectrum\TableOfContents\Content;

use Contao\ContentElement;

/**
 * This class renders the content element in the backend.
 */
class TableOfContents extends ContentElement
{
    /**
     * {@inheritDoc}
     */
    protected $strTemplate = 'ce_table-of-contents';

    /**
     * The placeholder to use.
     */
    const PLACE_HOLDER = '[[TABLE-OF-CONTENTS]]';

    /**
     * {@inheritDoc}
     */
    protected function compile()
    {
        // nothing to do in here, template and HOOK take care of rendering.
    }
}
