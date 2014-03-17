<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet;

use Symfony\Component\Yaml\Yaml;

/**
 * Description of Template
 *
 * @author krillzip
 */
class Template {

    public function getPath() {
        return __DIR__ . '/tpl';
    }

    public function getList() {
        $list = array();
        foreach (glob($this->getPath() . '/*.yml') as $row) {
            $list[] = strstr(substr($row, strrpos($row, '/') + 1), '.', true);
        }
        return $list;
    }
    
    protected function loadTemplate($tplName){
        $tplData = Yaml::parse($this->getPath() . '/' . $tplName . '.yml');
        return $tplData['template'];
    }

    public function render(
    $tpl = 'basic', array $settings, array $variables, array $collection
    ) {
        $data = $this->loadTemplate($tpl);
        
        foreach($variables as $varIndex => $var){
            if(!in_array($varIndex, $data['variables'])){
                unset($variables[$varIndex]);
            }
        }
        
        $settings = array_merge($data['settings'], $settings);

        include $this->getPath() . '/' . $tpl . '.php';
    }

}
