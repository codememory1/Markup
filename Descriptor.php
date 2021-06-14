<?php

namespace Codememory\Components\Markup;

use Codememory\Components\Markup\Interfaces\MarkupTypeInterface;
use Codememory\FileSystem\Interfaces\FileInterface;

/**
 * Class Descriptor
 *
 * @package Codememory\Components\Markup
 *
 * @author  Codememory
 */
class Descriptor
{

    /**
     * @var MarkupTypeInterface
     */
    private MarkupTypeInterface $markupType;

    /**
     * @var FileInterface
     */
    private FileInterface $filesystem;

    /**
     * @var mixed|null
     */
    private mixed $descriptor = null;

    /**
     * Descriptor constructor.
     *
     * @param MarkupTypeInterface $markupType
     * @param FileInterface       $filesystem
     */
    public function __construct(MarkupTypeInterface $markupType, FileInterface $filesystem)
    {

        $this->markupType = $markupType;
        $this->filesystem = $filesystem;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get a descriptor of a specific file
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $path
     * @param string $mode
     *
     * @return mixed
     */
    public function getDescriptor(string $path, string $mode = 'r+'): mixed
    {

        $this->descriptor = fopen($this->filesystem->getRealPath($path), $mode);

        return $this->descriptor;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>
     * Close open descriptor
     * <=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return void
     */
    public function closeDescriptor(): void
    {

        if (null !== $this->descriptor) {
            fclose($this->descriptor);
        }

    }

}