<?php

namespace SixtyNine\ClassGrapher\Helper;

class FileFinder
{
    public function find($dirName, $pattern = '*.php', $excludeDirs = array())
    {
        if (!is_dir($dirName)) {
            throw new \InvalidArgumentException("Invalid directory '$dirName'");
        }

        $files = glob(sprintf('%s/%s', $dirName, $pattern));

        foreach (glob($dirName . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            foreach ($excludeDirs as $excluded) {
                if (basename($dir) === $excluded) {
                    continue(2);
                }
            }

            $files = array_merge($files, $this->find($dir, $pattern, $excludeDirs));
        }

        return $files;
    }
}
