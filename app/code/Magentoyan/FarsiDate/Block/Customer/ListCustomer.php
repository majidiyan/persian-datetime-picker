<?php

namespace Magentoyan\FarsiDate\Block\Customer;

class ListCustomer extends \Magento\Review\Block\Customer\ListCustomer {

    public function dateFormat($date) {

        $jalaliObj = new \Magentoyan\FarsiDate\Model\Jalali();

        $auxAr1 = explode(' ', $date);
        $auxAr2 = explode('-', $auxAr1[0]);

        $auxAr3 = $jalaliObj->gregorianToJalali($auxAr2[0], $auxAr2[1], $auxAr2[2]);
        $farsiDate = implode('/', $auxAr3);
        return $farsiDate;
    }

}
