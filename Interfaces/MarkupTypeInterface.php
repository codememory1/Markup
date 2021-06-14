<?php

namespace Codememory\Components\Markup\Interfaces;

use Codememory\Components\Markup\Descriptor;
use Codememory\FileSystem\Interfaces\FileInterface;

/**
 * Interface MarkupTypeInterface
 *
 * @package Codememory\Components\Markup\Interfaces
 *
 * @author  Codememory
 */
interface MarkupTypeInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Set flags for used markup type
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param int $flags
     *
     * @return MarkupTypeInterface
     */
    public function setFlags(int $flags): MarkupTypeInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Open a specific file and save descriptor data
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param Descriptor    $descriptor
     * @param FileInterface $filesystem
     * @param string        $path
     *
     * @return MarkupTypeInterface
     */
    public function open(Descriptor $descriptor, FileInterface $filesystem, string $path): MarkupTypeInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get data from an open file
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function get(): array;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Overwrite data to a file of a specific format depending on the use of markup type
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $data
     *
     * @return bool
     */
    public function write(array $data): bool;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Change the data of an open file, a callback is accepted as an argument
     * in which a reference argument is passed which can be changed
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param callable $handler
     *
     * @return bool
     */
    public function change(callable $handler): bool;

}