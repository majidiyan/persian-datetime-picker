<?php

namespace Magentoyan\FarsiAdmin\Plugin\Element;

use Magentoyan\FarsiAdmin\Model\Jalali;

class AbstractBlock {

    private $_input;
    private $_jalali;

    public function __construct(Jalali $jalaliObj) {
        $this->_input = '';
        $this->_jalali = $jalaliObj;
    }

    public function beforeFormatDate(\Magento\Framework\View\Element\AbstractBlock $subject, $name) {




        $arrObj = is_object($name) ? get_object_vars($name) : $name;
        if (is_array($arrObj))
            $this->_input = @$arrObj['date'];
        else
            $this->_input = $arrObj;
    }

    public function afterFormatDate(\Magento\Framework\View\Element\AbstractBlock $subject, $result) {

        $sss = $this->_input;



        if ($sss == '')
            return $result;




        $auxAr1 = explode(' ', $sss);
        $auxAr2 = explode('-', $auxAr1[0]);

        $auxAr3 = $this->_jalali->gregorianToJalali($auxAr2[0], $auxAr2[1], $auxAr2[2]);
        $farsiAdmin = implode('/', $auxAr3);

        if (strlen($auxAr1[1]) > 0)            
            $farsiAdmin .= ' ' . date('h:i:s a', strtotime($auxAr1[1]) );
        

        return $farsiAdmin;
    }

}
