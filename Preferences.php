<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Krillzip\Biblesheet;

use Krillzip\Biblesheet\Exception\PreferenceException;
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
        $this->home = getenv('HOME').'/';
        $this->init();
    }
    
    public function __destruct() {
        $this->finilize();
    }
    
    protected function init() {
        if (!$this->preferenceFolderExists()) {
            $this->createPreferenceFolder();
        }

        $this->config = $this->loadPreferences();
    }
    
    protected function finilize(){
        $this->savePreferences();
    }
    
    protected function getSkeleton(){
        return array(
            'defaultProfile' => null,
            'workingFolder' => null,
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
            throw new PreferenceException('Couldn\t save file: ' . $this->home . Preferences::FILE_PREFERENCES);
        }
        return true;
    }

    protected function loadPreferences() {
        if (!file_exists($this->home . Preferences::FILE_PREFERENCES)){
            $this->savePreferences($this->getSkeleton());
        }
        $this->config = Yaml::parse($this->home . Preferences::FILE_PREFERENCES);
    }

}