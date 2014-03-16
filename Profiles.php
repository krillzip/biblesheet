<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet;

use Symfony\Component\Yaml\Yaml;
use Krillzip\Biblesheet\Exception\ProfilesException;

/**
 * Description of Profiles
 *
 * @author krillzip
 */
class Profiles {

    const PATH = '.biblesheet/profiles';

    protected $home;

    public function __construct() {
        $this->home = getenv('HOME') . '/';
        if (!is_dir($this->home . Profiles::PATH)) {
            if (!mkdir($this->home . Profiles::PATH, 0755, true)) {
                throw new ProfilesException('Could not create folder: ' . Profiles::PATH);
            }
        }
    }

    public function loadProfile($name) {
        try {
            $profile = Yaml::parse($this->home . Profiles::PATH . '/' . $name . '.yml');
        } catch (\Exception $e) {
            throw new ProfileException('Couldn\'t load or parse file: ' . $this->home . Profiles::PATH . '/' . $name . '.yml');
        }
        return $profile['profile'];
    }

    public function saveProfile($name, array $data) {
        $result = file_put_contents(
                $this->home . Profiles::PATH . '/' . $name . '.yml', Yaml::dump(array('profile' => $data))
        );
        if ($result === false) {
            throw new ProfileException('Couldn\'t save file: ' . $this->home . Profiles::PATH . '/' . $name . '.yml');
        }
    }

    public function showProfiles() {
        /*
         * @todo
         */
    }

    public function removeProfiles() {
        /*
         * @todo
         */
    }

    public function getSkeleton() {
        return array(
                'configuration' => array(),
        );
    }

}
