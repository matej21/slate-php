<?php

namespace Prezly\Slate\Tests;

use Prezly\Slate\Node;
use Prezly\Slate\Unserializer;
use InvalidArgumentException;

class UnserializerTest extends TestCase
{
    /** @var Unserializer */
    private $unserializer;

    protected function setUp()
    {
        parent::setUp();
        $this->unserializer = new Unserializer();
    }

    /**
     * The top level node of the Slate model is the Document. Any JSON that doesn't
     * have a top-level document node is invalid
     *
     * @see https://docs.slatejs.org/slate-core/document
     * @test
     */
    public function it_should_expect_top_level_document()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->unserializer->fromJSON("{}");
    }

    /**
     * Since the Slate model always has a top-level node (the Document), the result of unserialization
     * should always be a single Node instance
     *
     * @test
     */
    public function it_should_return_document_node()
    {
        $fixture = $this->loadFixture("00_empty_document.json");
        $node = $this->unserializer->fromJSON($fixture);
        $this->assertEquals(Node::KIND_DOCUMENT, $node->getKind());
    }
}