<?php

namespace Sven\ForgeCLI;

class Config
{
    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->file = $this->configFilePath();
    }

    /**
     * @param string|int $key
     * @param null $default
     *
     * @return string
     */
    public function get($key, $default = null)
    {
        return $this->readFile()[$key] ?? $default;
    }

    /**
     * @param string|int $key
     * @param string $value
     */
    public function set($key, $value = '')
    {
        $new = array_merge($this->readFile(), [$key => $value]);

        $this->writeToFile(json_encode($new));
    }

    /**
     * @return array
     */
    protected function readFile()
    {
        if (! is_file($this->file)) {
            $this->writeToFile('{}');
        }

        return json_decode(file_get_contents($this->file), true);
    }

    /**
     * @param string $data
     */
    public function writeToFile(string $data)
    {
        file_put_contents($this->file, $data.PHP_EOL);
    }

    /**
     * @return string
     */
    protected function configFilePath()
    {
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            $home = $_SERVER['USERPROFILE'];
        } else {
            $home = $_SERVER['HOME'];
        }

        return $home.DIRECTORY_SEPARATOR.'forge.json';
    }
}
