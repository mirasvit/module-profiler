<?php

namespace Mirasvit\Profiler\Model;

use Mirasvit\Profiler\Profile\Pool;
use Symfony\Component\Yaml\Dumper as YamlDumper;
use Symfony\Component\Yaml\Parser as YamlParser;

class Storage
{
    /**
     * @var Pool
     */
    private $pool;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Pool $profilePool,
        Config $config
    ) {
        $this->pool = $profilePool;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function dump()
    {
        $dump = [];

        foreach ($this->pool->getProfiles() as $code => $profile) {
            $dump[$code] = $profile->dump();
        }

        $meta = $dump['meta'];

        $name = (\DateTime::createFromFormat('U.u', microtime(true)))->format('Y-m-d H:i:s.u');

        $file = $this->config->getDumpPath() . $name . '.meta';
        file_put_contents($file, (new YamlDumper())->dump($meta, 10));

        $file = $this->config->getDumpPath() . $name . '.prof';
        file_put_contents($file, (new YamlDumper())->dump($dump, 10));

        return $name;
    }

    /**
     * @return array
     */
    public function load($file)
    {
        $content = file_get_contents($this->config->getDumpPath() . '/' . $file . '.prof');
        $dump = (new YamlParser())->parse($content);

        return $dump;
    }

    public function getList()
    {
        $result = [];
        $files = scandir($this->config->getDumpPath());

        foreach ($files as $file) {
            if ($file[0] == '.') {
                continue;
            }

            if (pathinfo($file)['extension'] != 'meta') {
                continue;
            }

            $content = file_get_contents($this->config->getDumpPath() . '/' . $file);
            $meta = (new YamlParser())->parse($content);

            $meta['ID'] = pathinfo($file)['filename'];

            $result[] = $meta;
        }

        return array_reverse($result);
    }
}