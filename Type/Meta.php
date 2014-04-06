<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet\Type;

use Krillzip\Biblesheet\Exception\MetaException;
use \PHPExcel_Cell;

/**
 * Description of Meta
 *
 * @author krillzip
 */
class Meta {

    protected $range;
    protected $headings;
    protected $headingsAsBooks;
    protected $width;
    protected $height;
    protected $variables;
    protected $settings;

    public function __construct(array $meta) {
        if (!empty($meta['range'])) {
            try {
                $this->range = PHPExcel_Cell::buildRange(PHPEXCEL_Cell::splitRange($meta['range']));
                list($this->width, $this->height) = PHPExcel_Cell::rangeDimension($this->range);
            } catch (\Exception $e) {
                $this->range = null;
            }
        }
        if (isset($meta['headings']) && is_int($meta['headings'])) {
            $this->headings = (int) $meta['headings'];
        }
        if (isset($meta['headingsAsBooks']) && is_bool($meta['headingsAsBooks'])) {
            $this->headingsAsBooks = (bool) $meta['headingsAsBooks'];
        }

        if (!empty($meta['variables']) && is_array($meta['variables'])) {
            $this->variables = $meta['variables'];
        }
        if (!empty($meta['settings']) && is_array($meta['settings'])) {
            $this->settings = $meta['settings'];
        }
    }

    protected static function metaFromJson($sheet) {
        $meta = array();

        $json = $sheet
                ->getSelectedSheet()
                ->getComment()
                ->getText()
                ->getPlainText()
        ;

        if (is_string($json)) {
            $json = json_decode($json);
            /* if ($json === null) {
              throw new MetaException('No meta found, or malformed data.');
              } */
        }
        if (is_array($json) || is_object($json)) {
            if (!empty($json->range)) {
                try {
                    $meta['range'] = PHPExcel_Cell::buildRange(PHPEXCEL_Cell::splitRange($json->range));
                    list($meta['width'], $meta['height']) = PHPExcel_Cell::rangeDimension($meta['range']);
                } catch (\Exception $e) {
                    $meta['range'] = null;
                }
            }
            if (isset($json->headings) && is_int($json->headings)) {
                $meta['headings'] = (int) $json->headings;
            }
            if (isset($json->headingsAsBooks) && is_bool($json->headingsAsBooks)) {
                $meta['headingsAsBooks'] = (bool) $json->headingsAsBooks;
            }
        }

        if (!empty($meta)) {
            return new Meta($meta);
        } else {
            return false;
        }
    }

    protected static function metaFromMetaSheet($sheet) {
        $meta = array();
        $variables = array();
        $settings = array();

        $metaSheet = $sheet->getMetaSheet();

        if (is_null($metaSheet)) {
            return null;
        }

        $row = 1;
        $goNext = true;

        while ($goNext) {

            $cell = $metaSheet->getCellByColumnAndRow(0, $row);
            $varName = $cell->getValue();
            $cell = $metaSheet->getCellByColumnAndRow(1, $row);
            $varValue = $cell->getValue();

            if (empty($varName)) {
                $goNext = false;
                break;
            } else {
                if (strpos($varName, 'var_') === 0) {
                    $variables[substr($varName, 4)] = $varValue;
                } elseif (strpos($varName, 'set_') === 0) {
                    $settings[substr($varName, 4)] = $varValue;
                } else {
                    $meta[$varName] = $varValue;
                }
                $row++;
            }
        }

        if (!empty($variables)) {
            $meta['variables'] = $variables;
        }
        if (!empty($settings)) {
            $meta['settings'] = $settings;
        }

        if (!empty($meta)) {
            return new Meta($meta);
        } else {
            return false;
        }
    }

    public function getRange() {
        return $this->range;
    }

    public function getHeadings() {
        return $this->headings;
    }

    public function getHeadingsAsBooks() {
        return $this->headingsAsBooks;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }
    
    public function getVariables(){
        return $this->variables;
    }
    
    public function getSettings(){
        return $this->settings;
    }

    public static function factory(Sheet $sheet) {

        try {
            $meta = self::metaFromMetaSheet($sheet);
            if ($meta === false) {
                $meta = self::metaFromJson($sheet);
            }
        } catch (MetaException $e) {
            return false;
        }

        return $meta;
    }

}
