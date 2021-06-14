<?php

namespace Codememory\Components\Markup\Interfaces;

/**
 * Interface MarkupInterface
 *
 * @package Codememory\Components\src\Markup\src\Interfaces
 *
 * @author  Codememory
 */
interface MarkupInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Add flags when using markup
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param int $flags
     *
     * @return MarkupInterface
     */
    public function setFlags(int $flags): MarkupInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Open a file with a specific markup type and use its methods
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return mixed
     */
    public function open(string $path): MarkupTypeInterface;

    /**
     * =>=>=>=>=>=>=>=>=>=>
     * Close open file
     * <=<=<=<=<=<=<=<=<=<=
     *
     * @return void
     */
    public function close(): void;

}