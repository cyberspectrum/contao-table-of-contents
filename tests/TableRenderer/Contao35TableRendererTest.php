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

namespace CyberSpectrum\TableOfContents\Test\TableRenderer;

use Contao\FrontendTemplate;
use CyberSpectrum\TableOfContents\TableRenderer\Contao35TableRenderer;

/**
 * This tests the Contao35TableRenderer class.
 */
class Contao35TableRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the class can be instantiated.
     *
     * @return void
     */
    public function testInstantiation()
    {
        $template = $this
            ->getMockBuilder(FrontendTemplate::class)
            ->setMethods(['parse'])
            ->disableOriginalConstructor()
            ->getMock();

        $renderer = new Contao35TableRenderer($template);

        $this->assertInstanceOf(Contao35TableRenderer::class, $renderer);
    }

    /**
     * Test the render method.
     *
     * @return void
     */
    public function testRender()
    {
        $test     = $this;
        $template = $this
            ->getMockBuilder(FrontendTemplate::class)
            ->setMethods(['parse'])
            ->disableOriginalConstructor()
            ->getMock();

        $linkList = ['id' => 'label', 'id2' => 'label 2'];

        $template->expects($this->once())->method('parse')->willReturnCallback(
            \Closure::bind(function () use ($test, $linkList) {
                $test->assertEquals($linkList, $this->linkList);
            }, $template, $template)
        );

        $renderer = new Contao35TableRenderer($template);
        $renderer->render($linkList);
    }
}
