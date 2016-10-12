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

namespace CyberSpectrum\TableOfContents\Test\Content;

use CyberSpectrum\TableOfContents\Content\TableOfContents;

class TableOfContentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the content element can be instantiated and renders the constant.
     *
     * @return void
     */
    public function testInstantiation()
    {
        /** @var TableOfContents $element */
        $element = $this
            ->getMockBuilder(TableOfContents::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $element->space = ['', ''];

        $this->assertInstanceOf(TableOfContents::class, $element);
    }
}
