<?php

namespace Codememory\Components\Markup\Types;

use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlType
 *
 * @package Codememory\Components\Markup\Types
 *
 * @author  Codememory
 */
final class YamlType extends AbstractMarkupType
{

    protected const EXTENSION = '.yaml';

    /**
     * @inheritDoc
     */
    public function get(): array
    {

        return Yaml::parse($this->getDataByOpenDescriptor()) ?: [];

    }

    /**
     * @inheritDoc
     */
    public function write(array $data): bool
    {

        $descriptor = $this->getDescriptor('w+');

        $dataInString = Yaml::dump($data, 3, 2, $this->flags);

        return (bool) fwrite($descriptor, $dataInString);

    }

}