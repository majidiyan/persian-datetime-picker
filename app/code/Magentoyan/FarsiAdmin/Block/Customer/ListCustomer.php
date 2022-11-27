<?php

namespace Magentoyan\FarsiAdmin\Block\Customer;

class ListCustomer extends \Magento\Review\Block\Customer\ListCustomer {

    public function dateFormat($date) {

        $jalaliObj = new \Magentoyan\FarsiAdmin\Model\Jalali();

        $auxAr1 = explode(' ', $date);
        $auxAr2 = explode('-', $auxAr1[0]);

        $auxAr3 = $jalaliObj->gregorianToJalali($auxAr2[0], $auxAr2[1], $auxAr2[2]);
        $farsiAdmin = implode('/', $auxAr3);
        return $farsiAdmin;
    }

}
