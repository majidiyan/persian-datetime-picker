<?php

namespace Magentoyan\FarsiDate\Plugin\Element;

use Magentoyan\FarsiDate\Model\Jalali;

class AbstractBlock {

    private $_input;
    private $_jalali;

    public function __construct(Jalali $jalaliObj) {
        $this->_input = '';
        $this->_jalali = $jalaliObj;
    }

    public function beforeFormatDate(\Magento\Framework\View\Element\AbstractBlock $subject, $name) {


        $this->_input = $name;
    }

    public function afterFormatDate(\Magento\Framework\View\Element\AbstractBlock $subject, $result) {


        $auxAr1 = explode(' ', $this->_input);
        $auxAr2 = explode('-', $auxAr1[0]);

        if(!isset($auxAr2[0]) || !isset($auxAr2[1]) || !isset($auxAr2[2]) )
            return '';

        $auxAr3 = $this->_jalali->gregorianToJalali($auxAr2[0], $auxAr2[1], $auxAr2[2]);
        $farsiDate = implode('/', $auxAr3);

        return $farsiDate;
    }

}
