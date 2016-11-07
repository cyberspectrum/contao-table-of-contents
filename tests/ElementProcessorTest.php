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

namespace CyberSpectrum\TableOfContents\Test;

use CyberSpectrum\TableOfContents\Content\TableOfContents;
use CyberSpectrum\TableOfContents\ElementProcessor;
use CyberSpectrum\TableOfContents\TableRenderer\TableRendererInterface;

/**
 * This tests the ElementProcessor class.
 */
class ElementProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the class can be instantiated.
     *
     * @return void
     */
    public function testInstantiation()
    {
        $parser = new ElementProcessor([], $this->getMockForAbstractClass(TableRendererInterface::class));

        $this->assertInstanceOf(ElementProcessor::class, $parser);
    }

    /**
     * Test that the elements are returned verbatim if no TOC element is listed.
     *
     * @return void
     */
    public function testProcessReturnsElementsWithoutTocElement()
    {
        $renderer = $this->getMockForAbstractClass(TableRendererInterface::class);
        $renderer->expects($this->never())->method('render');

        $parser = new ElementProcessor(['<h1 id="foo">Bar</h1>'], $renderer);
        $this->assertSame(['<h1 id="foo">Bar</h1>'], $parser->process());
    }

    /**
     * Data provider for the testProcess method
     *
     * @return array
     */
    public function testProcessProvider()
    {
        return [
            [ // #0
                // expected result headlines.
                [
                ],
                // input buffer
                [
                    TableOfContents::PLACE_HOLDER,
                    ''
                ]
            ],
            [ // #1
                // expected result headlines.
                [
                    'lvl1' => 'testing',
                    'lvl1.1' => 'testing makes sense',
                ],
                // input buffer
                [
                    TableOfContents::PLACE_HOLDER,
                    '<h1 id="lvl1">testing</h1>',
                    '<h2 id="lvl1.1">testing makes sense</h2>',
                ]
            ],
            [ // #2
                // expected result headlines.
                [
                    'lvl1' => 'testing',
                    'lvl1.1' => 'testing makes sense',
                    'auto-generated-id' => 'auto generated Id',
                ],
                // input buffer
                [
                    TableOfContents::PLACE_HOLDER,
                    '<h1 id="lvl1">testing</h1>',
                    '<h2 id="lvl1.1">testing makes sense</h2>',
                    '<h1>auto generated Id</h1>',
                ]
            ],
            [ // #3
                // expected result headlines.
                [
                    'lvl1' => 'testing äöü',
                    'lvl1.1' => 'testing makes sense',
                    'auto-generated-id' => 'auto generated Id',
                ],
                // input buffer
                [
                    TableOfContents::PLACE_HOLDER,
                    '<h1 id="lvl1">testing äöü</h1>',
                    '<h2 id="lvl1.1">testing makes sense</h2>',
                    '<h1>auto generated Id</h1>',
                ]
            ],
        ];
    }

    /**
     * Test that the parse method works correctly.
     *
     * @param array  $expected List of expected headlines.
     *
     * @param array  $input    List of input data.
     *
     * @return void
     *
     * @dataProvider testProcessProvider
     */
    public function testProcess($expected, $input)
    {
        $renderer = $this->getMockForAbstractClass(TableRendererInterface::class);
        $renderer->expects($this->once())->method('render')->with($expected);

        ElementProcessor::processElements($input, $renderer);
    }

    /**
     * Test data provider for testIdGetsAdded()
     *
     * @return array
     */
    public function testIdGetsAddedProvider()
    {
        return [
            // #1
            [
                // Expected Result.
                [
                    'TOC',
                    '<h1 id="auto-generated-id">auto generated Id</h1>',
                ],
                // Input buffer
                [
                    TableOfContents::PLACE_HOLDER,
                    '<h1>auto generated Id</h1>',
                ]
            ],
            // #2
            [
                // Expected Result.
                [
                    'TOC',
                    '<h1 id="with-uemlaut">with Ümlaut</h1>',
                ],
                // Input buffer
                [
                    TableOfContents::PLACE_HOLDER,
                    '<h1>with Ümlaut</h1>',
                ]
            ],
        ];
    }

    /**
     * Test that an id get's added if none present.
     *
     * @param array $expected The expected result elements.
     *
     * @param array $input    The input elements.
     *
     * @return void
     *
     * @dataProvider testIdGetsAddedProvider
     */
    public function testIdGetsAdded($expected, $input)
    {
        $renderer = $this->getMockForAbstractClass(TableRendererInterface::class);
        $renderer->expects($this->once())->method('render')->willReturn('TOC');

        $this->assertSame($expected, ElementProcessor::processElements($input, $renderer));
    }
}
