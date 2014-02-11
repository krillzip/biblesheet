<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet;

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

    public function render(
    $tpl = 'basic', array $settings, array $variables, array $collection
    ) {
        
    }

}
