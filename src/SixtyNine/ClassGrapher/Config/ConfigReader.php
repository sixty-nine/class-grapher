<?php


namespace SixtyNine\ClassGrapher\Config;


use SixtyNine\ClassGrapher\Graph\GraphConfig;
use SixtyNine\ClassGrapher\Graph\GraphFontConfig;
use SixtyNine\ClassGrapher\Graph\GraphNodeConfig;
use Symfony\Component\Yaml\Yaml;

class ConfigReader
{
    public function read($filename)
    {
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException('Config file not found: ' . $filename);
        }

        $yaml = new Yaml();
        $config = new GraphConfig();
        $content = $yaml->parse(file_get_contents($filename));
        $content = $this->arrayGet($content, 'graph', false);

        if ($content) {
            $this->configureNodes($config, $this->arrayGet($content, 'nodes', false));
            $this->configureFonts($config, $this->arrayGet($content, 'fonts', false));
        }

        return $config;
    }

    protected function configureFonts(GraphConfig $config, $params = array())
    {
        if ($params) {
            $this->configureFont($config->getBaseFont(), $this->arrayGet($params, 'base', false));
            $this->configureFont($config->getClassFont(), $this->arrayGet($params, 'class', false));
            $this->configureFont($config->getInterfaceFont(), $this->arrayGet($params, 'interface', false));
        }
    }

    protected function configureNodes(GraphConfig $config, $params = array())
    {
        if ($params) {
            $this->configureNode(
                $config->getClassNode(),
                $this->arrayGet($params, 'class', false)
            );

            $this->configureNode(
                $config->getInterfaceNode(),
                $this->arrayGet($params, 'interface', false)
            );
        }
    }

    protected function configureFont(GraphFontConfig $font, $params = array())
    {
        if ($params) {
            $font
                ->setStyle(GraphFontConfig::nameToStyle($this->arrayGet($params, 'style', false)))
                ->setColor($this->arrayGet($params, 'color', 'black'))
                ->setFont($this->arrayGet($params, 'font', GraphConfig::DEFAULT_FONT))
                ->setSize($this->arrayGet($params, 'size', GraphConfig::DEFAULT_FONT_SIZE))
            ;
        }
    }

    protected function configureNode(GraphNodeConfig $node, $params = array())
    {
        if ($params) {
            $node
                ->setShape($this->arrayGet($params, 'shape', GraphConfig::DEFAULT_NODE_SHAPE))
                ->setStyle($this->arrayGet($params, 'style', GraphConfig::DEFAULT_NODE_STYLE))
                ->setHeight($this->arrayGet($params, 'height', GraphConfig::DEFAULT_NODE_HEIGHT))
            ;
        }
    }

    protected function arrayGet($array, $key, $default)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        return $default;
    }
}
