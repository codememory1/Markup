<?php

namespace Codememory\Components\Markup\Types;

use Codememory\Components\Markup\Exceptions\IncorrectNestingIniException;
use Codememory\Support\ConvertType;
use JetBrains\PhpStorm\Pure;

/**
 * Class IniType
 *
 * @package Codememory\Components\Markup\Types
 *
 * @author  Codememory
 */
class IniType extends AbstractMarkupType
{

    /**
     * @var ConvertType
     */
    private ConvertType $convertType;

    /**
     * @var string|null
     */
    private ?string $iniInString = null;

    /**
     * IniType constructor.
     */
    #[Pure]
    public function __construct()
    {

        $this->convertType = new ConvertType();

    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {

        return parse_ini_string($this->getDataByOpenDescriptor(), true, $this->flags) ?: [];

    }

    /**
     * @inheritDoc
     * @throws IncorrectNestingIniException
     */
    public function write(array $data): bool
    {

        $descriptor = $this->getDescriptor('w+');

        return (bool) fwrite($descriptor, $this->parserOfArray($data));

    }


    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Parsing an array to ini format
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array $data
     * @param bool  $isRecursion
     *
     * @return string
     * @throws IncorrectNestingIniException
     */
    private function parserOfArray(array $data, bool $isRecursion = false): string
    {

        foreach ($data as $key => $value) {
            if (is_array($value) && !$isRecursion) {
                $this->iniInString .= sprintf("[%s]\n", $key);

                $this->parserOfArray($value, true);
            } elseif (is_array($value) && $isRecursion) {
                $this->nestingIni($value, $key);
            } else {
                $this->iniInString .= sprintf("%s = %s\n", $key, $this->encodeValue($value));
            }
        }

        return $this->iniInString;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * This method is responsible for nesting in the array when parsing
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param array  $value
     * @param string $key
     *
     * @return void
     * @throws IncorrectNestingIniException
     *
     */
    private function nestingIni(array $value, string $key): void
    {

        foreach ($value as $nestingKey => $nestingValue) {
            if (is_array($nestingValue)) {
                throw new IncorrectNestingIniException();
            }

            $this->iniInString .= sprintf("%s[%s] = %s\n", $key, $nestingKey, $this->encodeValue($nestingValue));
        }

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Encoding array value into ini format
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param mixed $value
     *
     * @return mixed
     */
    private function encodeValue(mixed $value): mixed
    {

        if (is_string($value)) {
            $value = sprintf('"%s"', $value);
        } elseif (is_bool($value)) {
            $value = sprintf('%s', $value ? 'true' : 'false');
        }

        return $value;

    }

}