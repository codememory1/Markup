<?php

namespace Codememory\Components\Markup\Types;

use Codememory\Components\Markup\TypeAbstract;

/**
 * Class IniType
 * @package Codememory\Components\src\Markup\src\Types
 *
 * @author Codememory
 */
class IniType extends TypeAbstract
{

    protected const EXPANSION = '.ini';

    /**
     * @var ?string
     */
    private ?string $dataParse = null;

    /**
     * {@inheritdoc}
     */
    public function open(): bool|array
    {

        $parse = parse_ini_string($this->read(), true, $this->flags);

        if(is_bool($parse)) {
            return [];
        }

        return $parse;

    }

    /**
     * {@inheritdoc}
     */
    public function write(array $data): bool
    {

        $this->toIni($data);
        $this->file->writer
            ->open($this->generatePath(), createFile: true)
            ->put($this->dataParse);

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

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Set the value of a configuration setting by passing
     * an array or string of configuration keys and their new value
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string|array          $keys
     * @param string|int|array|null $value
     *
     * @return IniType
     */
    public function setIni(string|array $keys, null|string|int|array $value = null): IniType
    {

        if (is_array($keys)) {
            foreach ($keys as $index => $key) {
                ini_set($key, is_array($value) ? $value[$index] : $value);
            }
        } else {
            ini_set($keys, $value);
        }

        return $this;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get configuration value by passing 2 argument means whether
     * to show detailed information about the configuration key
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string|array $keys
     * @param bool         $more
     *
     * @return array
     * @throws IncorrectExtensionIniException
     */
    public function getIni(string|array $keys, bool $more = true): array
    {

        $settings = [];
        $all = $this->getAllIni(more: $more);

        if (is_array($keys)) {
            foreach ($keys as $key) {
                if (array_key_exists($key, $all)) {
                    $settings[$key] = $all[$key];
                }
            }
        } else {
            if (array_key_exists($keys, $all)) {
                $settings[$keys] = $all[$keys];
            }
        }

        return $settings;

    }

    /**
     * =>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>=>
     * Get a list of all configuration. By passing 1 as the
     * extension argument, this is the part of the key name up
     * to a period. Example: allow.name
     * <=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=<=
     *
     * @param string|null $extension
     * @param bool        $more
     *
     * @return array
     * @throws IncorrectExtensionIniException
     */
    public function getAllIni(?string $extension = null, bool $more = true): array
    {

        $allSettings = ini_get_all(details: $more);

        if (null !== $extension) {
            $allSettings = array_filter($allSettings, function (mixed $value, mixed $key) use ($extension) {
                $regex = sprintf('/^%s\./', $extension);

                if (preg_match($regex, $key)) {
                    return $value;
                }
            }, ARRAY_FILTER_USE_BOTH);

            if ([] === $allSettings) {
                throw new IncorrectExtensionIniException($extension);
            }
        }

        if ([] !== $allSettings) {
            foreach ($allSettings as $key => $value) {
                if (false === is_array($value)) {
                    $allSettings[$key] = ConvertType::ofString($value);
                }
            }
        }

        return $allSettings;


    }

    /**
     * @param array|object $data
     *
     * @return IniType
     */
    private function toIni(array|object $data): IniType
    {

        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $value = (array) $value;
            }

            if (false === is_array($value)) {
                $string = "%s = %s\n";

                if (true === is_bool($value)) {
                    $value = sprintf("%s", false === $value ? 'false' : 'true');
                } else {
                    $value = is_string($value) ? sprintf("\"%s\"", $value) : $value;
                }

                $this->dataParse .= sprintf($string, $key, preg_quote($value, '/'));
            } else {
                $this->dataParse .= sprintf("[%s]\n", $key);
                $this->toIni($value);
            }
        }

        return $this;

    }

}