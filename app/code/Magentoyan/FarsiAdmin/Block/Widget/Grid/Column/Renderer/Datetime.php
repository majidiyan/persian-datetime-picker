<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magentoyan\FarsiAdmin\Block\Widget\Grid\Column\Renderer;

/**
 * Backend grid item renderer datetime
 *
 * @api
 * @deprecated 100.2.0 in favour of UI component implementation
 * @since 100.0.2
 */
class Datetime extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\Datetime {

    /**
     * Renders grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    private function normalizeDate($dateString) {
        
        $monthAr = ["-", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $auxAr1 = explode(' ', $dateString);
        $monthStr = $auxAr1[0];
        $yearStr = $auxAr1[2];
        $dayStr = substr($auxAr1[1], 0, -1);

        $monthStr = array_search($monthStr, $monthAr);

        $monthStr = intval($monthStr) < 10 ? '0' . intval($monthStr) : $monthStr;
        $dayStr = intval($dayStr) < 10 ? '0' . intval($dayStr) : $dayStr;
        
        $timePart = '';

                    
        for($i = 0; $i < count($auxAr1); $i++)
            if($i > 2)
                $timePart = $timePart .' '.$auxAr1[$i];
            
            return [$yearStr . '-' . $monthStr . '-' . $dayStr , $timePart];
        
    }

    public function render(\Magento\Framework\DataObject $row) {
        $format = $this->getColumn()->getFormat();



        $date = $this->_getValue($row);
        if ($date) {
            if (!($date instanceof \DateTimeInterface)) {
                $date = new \DateTime($date);
            }

            //majidian
            $aux = $this->_localeDate->formatDateTime(
                    $date,
                    $format ?: \IntlDateFormatter::MEDIUM,
                    $format ?: \IntlDateFormatter::MEDIUM,
                    null,
                    $this->getColumn()->getTimezone() === false ? 'UTC' : null
            );

            $auxAr = $this->normalizeDate($aux);
            
            $jalaliObj = new \Magentoyan\FarsiAdmin\Model\Jalali();

            
            $auxAr2 = explode('-', $auxAr[0]);
            $auxAr3 = $jalaliObj->gregorianToJalali($auxAr2[0], $auxAr2[1], $auxAr2[2]);
            $farsiDate = implode('/', $auxAr3);
            return $farsiDate.$auxAr[1];
            //majidian end
            
            
            return $this->_localeDate->formatDateTime(
                            $date,
                            $format ?: \IntlDateFormatter::MEDIUM,
                            $format ?: \IntlDateFormatter::MEDIUM,
                            null,
                            $this->getColumn()->getTimezone() === false ? 'UTC' : null
            );
        }


       
        return $this->getColumn()->getDefault();
    }

}
