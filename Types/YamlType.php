<?php

namespace Codememory\Components\Markup\Types;

use Codememory\Components\Markup\TypeAbstract;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlType
 * @package Codememory\Components\src\Markup\src\Interfaces\Types
 *
 * @author  Codememory
 */
class YamlType extends TypeAbstract
{

    protected const EXPANSION = '.yaml';

    public const DUMP_OBJECT = 1;
    public const PARSE_EXCEPTION_ON_INVALID_TYPE = 2;
    public const PARSE_OBJECT = 4;
    public const PARSE_OBJECT_FOR_MAP = 8;
    public const DUMP_EXCEPTION_ON_INVALID_TYPE = 16;
    public const PARSE_DATETIME = 32;
    public const DUMP_OBJECT_AS_MAP = 64;
    public const DUMP_MULTI_LINE_LITERAL_BLOCK = 128;
    public const PARSE_CONSTANT = 256;
    public const PARSE_CUSTOM_TAGS = 512;
    public const DUMP_EMPTY_ARRAY_AS_SEQUENCE = 1024;
    public const DUMP_NULL_AS_TILDE = 2048;

    /**
     * {@inheritdoc}
     */
    public function open(): array
    {

        if (null === $this->read()) {
            return [];
        }

        return Yaml::parse($this->read());

    }

    /**
     * {@inheritdoc}
     */
    public function write(array $data, int $inline = 3, int $indent = 2): bool
    {

        $this->file->writer
            ->open($this->generatePath(), createFile: true)
            ->put(Yaml::dump($data, $inline, $indent, $this->flags));

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function change(callable $handler): bool
    {

        $data = $this->open();

        call_user_func_array($handler, [&$data]);

        $this->write($data);

        return true;

    }

}