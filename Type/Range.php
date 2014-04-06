<?php

/*
 * (c) Kristoffer Paulsson <krillzip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krillzip\Biblesheet\Type;

use Krillzip\Biblesheet\Type\Sheet;
use Krillzip\Biblesheet\Type\Meta;
use Krillzip\Biblesheet\Exception\RangeException;

/**
 * Description of Range
 *
 * @author krillzip
 */
class Range {

    protected $data;

    protected function __construct(array $data = array()) {
        $this->data = $data;
    }

    public function flattenData() {
        $data = array();
        foreach ($this->data as $rowNum => $col) {
            foreach ($col as $colName => $text) {
                if(!empty($text)){
                    $data[] = new Reference($text, $colName . $rowNum);
                }
            }
        }
        return $data;
    }

    protected static function walk(Sheet $sheet) {
        return $sheet->getSelectedSheet()->toArray(null, false, false, true);
    }

    protected static function walkRange(Sheet $sheet, $range) {
        return $sheet->getSelectedSheet()->rangeToArray($range, null, false, false, true);
    }

    public static function factory(Sheet $sheet, $meta = null) {

        if ($meta instanceof Meta) {
            $range = $meta->getRange();
            $data = (isset($range)) ?
                    self::walkRange($sheet, $range) :
                    self::walk($sheet)
            ;
        } else if (is_string($meta) && !empty($meta)) {
            $data = self::walkRange($sheet, $range);
        } else if (is_null($meta)) {
            $data = self::walk($sheet);
        } else {
            throw new RangeException('Illegal range, must be: class Meta or string of type "A1:D4" or null.');
        }
        return new Range($data);
    }

}
