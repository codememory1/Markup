<?php

namespace Codememory\Components\Markup\Interfaces;

use Codememory\Components\Markup\TypeAbstract;

/**
 * Interface MarkupInterface
 * @package Codememory\Components\src\Markup\src\Interfaces
 *
 * @author  Codememory
 */
interface MarkupInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Set any flags before opening the file
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param int $flags
     *
     * @return MarkupInterface
     */
    public function setFlags(int $flags): MarkupInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Open a file in which you want to write or change
     * information or read, the path must be without the
     * file extension
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string $filename
     *
     * @return MarkupInterface|TypeAbstract
     */
    public function open(string $filename): MarkupInterface|TypeAbstract;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get an array of all information from a file
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return array
     */
    public function get(): array;

}