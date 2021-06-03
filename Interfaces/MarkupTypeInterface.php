<?php

namespace Codememory\Components\Markup\Interfaces;

/**
 * Interface MarkupTypeInterface
 * @package Codememory\Components\Markup\Interfaces
 *
 * @author Codememory
 */
interface MarkupTypeInterface
{

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Open a file and get the result as an array
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @return mixed
     */
    public function open(): mixed;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Write data to a file, the array will be parsed into a
     * certain markup format, if the file does not exist, it
     * will be created and the result of the parsing of the
     * array will be written to it
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $data
     *
     * @return bool
     */
    public function write(array $data): bool;

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Modify file data using callback. Callback takes
     * 1 array $data argument and this argument must be
     * a reference
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param callable $handler
     *
     * @return bool
     */
    public function change(callable $handler): bool;

}