<?php
namespace Mirasvit\Profiler\Model;

use Symfony\Component\Yaml\Dumper as YamlDumper;

class Storage
{
    /**
     * @var Profile\Pool
     */
    protected $pool;

    public function __construct(
        Profile\Pool $profilePool
    ) {
        $this->pool = $profilePool;
    }

    public function dump()
    {
        $dump = [];

        foreach ($this->pool->getProfiles() as $code => $profile) {
            $dump[$code] = $profile->dump();
        }

        $path = BP . '/var/profiler/';
        if (!file_exists($path)) {
            mkdir($path);
        }

        $file = $path . microtime(true) . '.yaml';
        $dumper = new YamlDumper();
        $yaml = $dumper->dump($dump, 10);

        file_put_contents($file, $yaml);
    }

    public function load()
    {

    }
}