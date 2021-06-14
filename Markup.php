<?php

namespace Codememory\Components\Markup;

use Codememory\Components\Markup\Interfaces\MarkupInterface;
use Codememory\Components\Markup\Interfaces\MarkupTypeInterface;
use Codememory\FileSystem\File;
use Codememory\FileSystem\Interfaces\FileInterface;

/**
 * Class Markup
 *
 * @package Codememory\Components\Markup
 *
 * @author  Codememory
 */
class Markup implements MarkupInterface
{

    public const CREATE_NON_EXIST = 1;

    /**
     * @var MarkupTypeInterface
     */
    private MarkupTypeInterface $markupType;

    /**
     * @var FileInterface
     */
    private FileInterface $filesystem;

    /**
     * @var string|int
     */
    private string|int $flags = 0;

    /**
     * @var Descriptor
     */
    private Descriptor $descriptor;

    /**
     * Markup constructor.
     */
    public function __construct(MarkupTypeInterface $markupType)
    {

        $this->markupType = $markupType;
        $this->filesystem = new File();
        $this->descriptor = new Descriptor($this->markupType, $this->filesystem);

    }

    /**
     * @inheritDoc
     */
    public function setFlags(string|int $flags): MarkupInterface
    {

        $this->flags = $flags;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function open(string $path): MarkupTypeInterface
    {

        $path = $path.$this->markupType->getExtension();

        if (!$this->filesystem->exist($path) && $this->flags & self::CREATE_NON_EXIST) {
            file_put_contents($this->filesystem->getRealPath($path), null);

            $this->filesystem->setPermission($path);
        }

        $this->markupType->open($this->descriptor, $this->filesystem, $path);

        return $this->markupType;

    }

    /**
     * @inheritDoc
     */
    public function close(): void
    {

        $this->markupType->closeOpenedDescriptor();

    }

}