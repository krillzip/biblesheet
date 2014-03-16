<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet;

use Krillzip\Biblesheet\Exception\PreferenceException;
use Krillzip\Diatheke\Configuration;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of Preferences
 *
 * @author krillzip
 */
class Preferences {

    const PATH = '.biblesheet';
    const FILE_PREFERENCES = '.biblesheet/preferences.yaml';

    protected $home;
    protected $config = array();

    public function __construct() {
        $this->home = getenv('HOME') . '/';
        $this->init();
    }

    public function __destruct() {
        $this->finilize();
    }

    protected function init() {
        if (!$this->preferenceFolderExists()) {
            $this->createPreferenceFolder();
        }

        if (!file_exists($this->home . Preferences::FILE_PREFERENCES)) {
            $this->savePreferences($this->getSkeleton());
        }
        $this->config = $this->loadPreferences();
    }

    protected function finilize() {
        $this->savePreferences();
    }

    protected function getSkeleton() {
        return array(
            'preferences' => array(
                'defaultProfile' => 'default',
                'workingFolder' => null,
            ),
        );
    }

    protected function preferenceFolderExists() {
        return is_dir($this->home . Preferences::PATH);
    }

    protected function createPreferenceFolder() {
        if (mkdir($this->home . Preferences::PATH, 0755, true)) {
            return true;
        } else {
            throw new PreferenceException('Could not create folder: ' . Preferences::PATH);
        }
    }

    protected function savePreferences(array $data = array()) {
        if (empty($data)) {
            $result = file_put_contents(
                    $this->home . Preferences::FILE_PREFERENCES, Yaml::dump($this->config)
            );
        } else {
            $result = file_put_contents(
                    $this->home . Preferences::FILE_PREFERENCES, Yaml::dump($data)
            );
        }
        if ($result === false) {
            throw new PreferenceException('Couldn\'t save file: ' . $this->home . Preferences::FILE_PREFERENCES);
        }
        return true;
    }

    protected function loadPreferences() {
        return Yaml::parse($this->home . Preferences::FILE_PREFERENCES);
    }

    public function getSetting($path) {
        return $this->config['preferences'][$path];
    }

    public function setSetting($path, $value) {
        $this->config['preferences'][$path] = $value;
    }

}
