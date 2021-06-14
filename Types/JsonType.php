<?php

namespace Codememory\Components\Markup\Types;

/**
 * Class JsonType
 *
 * @package Codememory\Components\Markup\Types
 *
 * @author  Codememory
 */
final class JsonType extends AbstractMarkupType
{

    protected const EXTENSION = '.json';

    /**
     * @inheritDoc
     */
    public function get(): array
    {

        return json_decode($this->getDataByOpenDescriptor(), flags: $this->flags) ?: [];

    }

    /**
     * @inheritDoc
     */
    public function write(array $data): bool
    {

        $descriptor = $this->getDescriptor('w+');

        return (bool) fwrite($descriptor, json_encode($data, $this->flags));

    }

}