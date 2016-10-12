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

namespace CyberSpectrum\TableOfContents\Hook;

use Contao\FrontendTemplate;
use Contao\Template;
use CyberSpectrum\TableOfContents\ElementProcessor;
use CyberSpectrum\TableOfContents\TableRenderer\Contao35TableRenderer;

/**
 * This class handles the parseArticle HOOK to generate the table of contents.
 */
class ParseArticle
{
    /**
     * Hook receiver for compileArticle hook.
     *
     * @param Template $template The template.
     *
     * @return void
     */
    public function compileArticle(Template $template)
    {
        $template->elements = ElementProcessor::processElements(
            $template->elements,
            new Contao35TableRenderer(new FrontendTemplate('ce_table-of-contents_list'))
        );
    }
}
