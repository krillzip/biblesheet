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

    public function __construct($json) {
        if (is_string($json)) {
            $json = json_decode($json);
            if ($json === null) {
                throw new MetaException('No meta found, or malformed data.');
            }
        }
        if (is_array($json) || is_object($json)) {
            if (!empty($json['range'])) {
                try {
                    $this->range = PHPExcel_Cell::buildRange(PHPEXCEL_Cell::splitRange($json['range']));
                    list($this->width, $this->height) = PHPExcel_Cell::rangeDimension($this->range);
                } catch (\Exception $e) {
                    $this->range = null;
                }
            }
            if (isset($json['headings']) && is_int($json['headings'])) {
                $this->headings = (int) $json['headings'];
            }
            if (isset($json['headingsAsBooks']) && is_bool($json['headingsAsBooks'])) {
                $this->headingsAsBooks = (bool) $json['headingsAsBooks'];
            }
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

    public static function factory(Sheet $sheet) {
        $comment = $sheet
                ->getSelectedSheet()
                ->getComment()
                ->getText()
                ->getPlainText()
        ;
        try {
            $meta = new Meta($comment);
        } catch (MetaException $e) {
            return false;
        }

        return $meta;
    }

}
