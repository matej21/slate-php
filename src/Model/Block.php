<?php

namespace Prezly\Slate\Model;

class Block implements Node
{
    /** @var string */
    private $type;

    /** @var array */
    private $data = [];

    /** @var Node[]|Text[] */
    private $nodes = [];

    /** @var bool */
    private $is_void;

    /**
     * @param string $type
     * @param array $data
     * @param Node[]|Text[] $nodes
     * @param bool $is_void
     */
    public function __construct(string $type, array $data = [], array $nodes = [], bool $is_void = false)
    {
        $this->type = $type;
        $this->data = $data;
        $this->is_void = $is_void;

        foreach ($nodes as $node) {
            $this->addNode($node);
        }
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return Node[]|Text[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * @return bool
     */
    public function isVoid(): bool
    {
        return $this->is_void;
    }

    /**
     * @param bool $is_void
     */
    public function setIsVoid(bool $is_void): void
    {
        $this->is_void = $is_void;
    }

    /**
     * @param Node|Text $node
     * @return Block
     */
    public function addNode(Entity $node): Block
    {
        if ($node instanceof Node || $node instanceof Text) {
            $this->nodes[] = $node;
            return $this;
        }

        throw new \InvalidArgumentException('Block can only have Node and Text child nodes');
    }

    public function getText(): string
    {
        $text = '';
        foreach ($this->nodes as $node) {
            $text .= $node->getText();
        }
        return $text;
    }

    public function jsonSerialize()
    {
        return (object)[
            'object' => Entity::BLOCK,
            'type'   => $this->type,
            'isVoid' => $this->is_void,
            'data'   => (object)$this->data,
            'nodes'  => array_map(function (Entity $node) {
                return $node->jsonSerialize();
            }, $this->nodes)
        ];
    }
}
