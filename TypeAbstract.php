<?php

namespace Codememory\Components\Markup;

use Codememory\FileSystem\File;
use Codememory\Components\Markup\Interfaces\MarkupTypeInterface;

/**
 * Class TypeAbstract
 * @package Codememory\Components\src\Markup\src
 *
 * @author  Codememory
 */
abstract class TypeAbstract implements MarkupTypeInterface
{

    /**
     * @var File
     */
    protected File $file;

    /**
     * @var ?string
     */
    protected ?string $filename = null;

    /**
     * @var int
     */
    protected int $flags = 0;

    /**
     * TypeAbstract constructor.
     */
    public function __construct()
    {

        $this->file = new File();

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Adding a path that should be open for reading
     * and other actions
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $filename
     *
     * @return $this
     */
    public function setFilename(string $filename): TypeAbstract
    {

        $this->filename = $filename;

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Adding flags
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param int $flags
     *
     * @return $this
     */
    public function setFlags(int $flags): TypeAbstract
    {

        $this->flags = $flags;

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Read the file and return the result as a string, if
     * the file does not exist, it will be created
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return string|null
     */
    protected function read(): ?string
    {

        return $this->file->reader
            ->open($this->generatePath(), createFile: true)
            ->read();

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the full path to a file by appending an
     * extension to it
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return string
     */
    protected function generatePath(): string
    {

        return $this->filename . static::EXPANSION;

    }

}