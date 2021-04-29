<?php

namespace Codememory\Components\Markup;

use Codememory\Components\Markup\Interfaces\MarkupInterface;
use Codememory\Components\Markup\Interfaces\MarkupTypeInterface;

/**
 * Class Markup
 * @package Codememory\Components\src\Markup\src
 *
 * @author  Codememory
 */
class Markup implements MarkupInterface
{

    /**
     * @var MarkupTypeInterface
     */
    private MarkupTypeInterface $type;

    /**
     * @var string|null
     */
    private ?string $openFile = null;

    /**
     * @var int
     */
    private int $flags = 0;

    /**
     * Markup constructor.
     *
     * @param MarkupTypeInterface $type
     */
    public function __construct(MarkupTypeInterface $type)
    {

        $this->type = $type;

    }

    /**
     * {@inheritdoc}
     */
    public function setFlags(int $flags): MarkupInterface
    {

        $this->flags = $flags;

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function open(string $filename): TypeAbstract|MarkupInterface
    {

        $this->openFile = $filename;

        $this->type
            ->setFilename($this->openFile)
            ->setFlags($this->flags);

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function get(): array
    {

        return $this->type->open();

    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments): mixed
    {

        return call_user_func_array([$this->type, $method], $arguments);

    }

}