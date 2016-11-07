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

namespace CyberSpectrum\TableOfContents;

use CyberSpectrum\TableOfContents\Content\TableOfContents;
use CyberSpectrum\TableOfContents\TableRenderer\TableRendererInterface;

/**
 * This class extracts the headlines from elements and renders the table of contents then.
 */
class ElementProcessor
{
    /**
     * The element list.
     *
     * @var string[]
     */
    private $elements;

    /**
     * The template to generate the table of contents.
     *
     * @var TableRendererInterface
     */
    private $renderer;

    /**
     * Create a new instance.
     *
     * @param string[]               $elements The element list.
     *
     * @param TableRendererInterface $renderer The template to generate the table of contents.
     */
    public function __construct(array $elements, TableRendererInterface $renderer)
    {
        $this->elements = $elements;
        $this->renderer = $renderer;
    }

    /**
     * Convenience method.
     *
     * @param string[]               $elements The element list.
     *
     * @param TableRendererInterface $renderer The template to generate the table of contents.
     *
     * @return string[]
     */
    public static function processElements(array $elements, TableRendererInterface $renderer)
    {
        $processor = new static($elements, $renderer);

        return $processor->process();
    }

    /**
     * Processor function, returns the updated element list.
     *
     * @return string[]
     */
    public function process()
    {
        $headlines = [];
        $tocIndex  = null;
        $elements  = $this->elements;

        foreach ($elements as $key => $element) {
            if (strpos($element, TableOfContents::PLACE_HOLDER) !== false) {
                $tocIndex = $key;
                continue;
            }
            if (!trim($element)) {
                continue;
            }

            $doc = new \DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML(mb_convert_encoding($element, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();

            for ($level = 0; $level < 6; $level++) {
                $found = $doc->getElementsByTagName('h' . $level);
                foreach ($found as $headline) {
                    /** @var \DOMElement $headline */
                    $id = $headline->getAttribute('id');
                    if (!$id) {
                        $id  = standardize($headline->textContent);
                        $pre = (string) $doc->saveHTML($headline);
                        $headline->setAttribute('id', $id);
                        $elements[$key] = str_replace($pre, $doc->saveHTML($headline), $elements[$key]);
                    }

                    $headlines[$id] = $headline->textContent;
                }
            }
            unset($doc);
        }

        if (null === $tocIndex) {
            return $elements;
        }

        $elements[$tocIndex] = str_replace(
            TableOfContents::PLACE_HOLDER,
            $this->renderer->render($headlines),
            $elements[$tocIndex]
        );

        return $elements;
    }
}
