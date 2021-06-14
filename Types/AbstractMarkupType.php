<?php

namespace Codememory\Components\Markup\Types;

use Codememory\Components\Markup\Descriptor;
use Codememory\Components\Markup\Interfaces\MarkupTypeInterface;
use Codememory\FileSystem\Interfaces\FileInterface;
use LogicException;

/**
 * Class AbstractMarkupType
 *
 * @package Codememory\Components\Markup\Types
 *
 * @author  Codememory
 */
abstract class AbstractMarkupType implements MarkupTypeInterface
{

    /**
     * @var int
     */
    protected int $flags = 0;

    /**
     * @var ?Descriptor
     */
    protected ?Descriptor $descriptor = null;

    /**
     * @var mixed|null
     */
    protected mixed $openedDescriptor = null;

    /**
     * @var ?FileInterface
     */
    protected ?FileInterface $filesystem = null;

    /**
     * @var ?string
     */
    private ?string $openedPath = null;

    /**
     * @inheritDoc
     */
    public function setFlags(int $flags): MarkupTypeInterface
    {

        $this->flags = $flags;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function open(Descriptor $descriptor, FileInterface $filesystem, string $path): MarkupTypeInterface
    {

        $this->descriptor = $descriptor;
        $this->filesystem = $filesystem;
        $this->openedDescriptor = fopen($this->filesystem->getRealPath($path), 'r');
        $this->openedPath = $path;

        return $this;

    }

    /**
     * @inheritDoc
     */
    public function change(callable $handler): bool
    {

        $currentData = $this->get();
        $this->closeOpenedDescriptor();

        call_user_func_array($handler, [&$currentData]);

        return $this->write($currentData);
    }

    /**
     * @inheritDoc
     */
    public function getExtension(): string
    {

        return static::EXTENSION;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Close open handle / file
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return void
     */
    public function closeOpenedDescriptor(): void
    {

        if (null !== $this->descriptor) {
            $this->descriptor->closeDescriptor();
        }

        if (is_resource($this->openedDescriptor)) {
            fclose($this->openedDescriptor);
        }

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns unprocessed data of an open file
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return string|null
     */
    protected function getDataByOpenDescriptor(): ?string
    {

        if (null === $this->openedDescriptor) {
            return null;
        }

        fseek($this->openedDescriptor, 0);

        return stream_get_contents($this->openedDescriptor);

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Returns the descriptor of an open file; an exception is thrown
     * if the file is not opened
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $mode
     *
     * @return mixed
     */
    protected function getDescriptor(string $mode): mixed
    {

        if (null === $this->descriptor) {
            throw new LogicException('Can\'t get descriptor because file was not open');
        }

        return $this->descriptor->getDescriptor($this->openedPath, $mode);

    }

}