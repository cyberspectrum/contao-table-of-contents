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

use Contao\Template;

/**
 * This class is the table renderer with Contao 3.5 compatible frontend template rendering.
 */
class Contao35TableRenderer implements TableRendererInterface
{
    /**
     * The Contao template.
     *
     * @var Template
     */
    private $template;

    /**
     * Create a new instance.
     *
     * @param Template $template The template to use for rendering.
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * {@inheritDoc}
     */
    public function render($linkList)
    {
        $this->template->linkList = $linkList;

        return $this->template->parse();
    }
}
