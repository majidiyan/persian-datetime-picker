<?php
namespace Magentoyan\FarsiDate\Model\Order\Email\Sender;

use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Email\Container\OrderIdentity;
use Magento\Sales\Model\Order\Email\Container\Template;
use Magento\Sales\Model\Order\Email\Sender;
use Magento\Sales\Model\ResourceModel\Order as OrderResource;
use Magento\Sales\Model\Order\Address\Renderer;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\DataObject;

use Magentoyan\FarsiDate\Model\Order\Email\OrderSender as OrderSenderHelper;

class OrderSender extends \Magento\Sales\Model\Order\Email\Sender\OrderSender
{
    
    protected $_parentOfParent;
    protected $_jalali;
    
    
    public function __construct(\Magento\Sales\Model\Order\Email\Container\Template $templateContainer, 
            \Magento\Sales\Model\Order\Email\Container\OrderIdentity $identityContainer, 
            \Magento\Sales\Model\Order\Email\SenderBuilderFactory $senderBuilderFactory, 
            \Psr\Log\LoggerInterface $logger, 
            \Magento\Sales\Model\Order\Address\Renderer $addressRenderer, 
            \Magento\Payment\Helper\Data $paymentHelper, 
            \Magento\Sales\Model\ResourceModel\Order $orderResource, 
            \Magento\Framework\App\Config\ScopeConfigInterface $globalConfig, 
            \Magento\Framework\Event\ManagerInterface $eventManager,
            
            OrderSenderHelper $parentOfParent,
            \Magentoyan\FarsiAdmin\Model\Jalali $jalali
            ) {
        parent::__construct(
                $templateContainer, 
                $identityContainer, 
                $senderBuilderFactory, 
                $logger, 
                $addressRenderer, 
                $paymentHelper, 
                $orderResource, 
                $globalConfig, 
                $eventManager
                );
        
                $this->_parentOfParent = $parentOfParent;
                $this->_jalali = $jalali;
    }
    
    
    protected function prepareTemplate(Order $order)
    {
        
        $farsiNums = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', ];
        $enNum = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ];
        
        $transport = [
            'order' => $order,
            'order_id' => $order->getId(),
            'billing' => $order->getBillingAddress(),
            'payment_html' => $this->getPaymentHtml($order),
            'store' => $order->getStore(),
            'formattedShippingAddress' => $this->getFormattedShippingAddress($order),
            'formattedBillingAddress' => $this->getFormattedBillingAddress($order),
            'created_at_formatted' => $order->getCreatedAtFormatted(3),
            'order_data' => [
                'customer_name' => $order->getCustomerName(),
                'is_not_virtual' => $order->getIsNotVirtual(),
                'email_customer_note' => $order->getEmailCustomerNote(),
                'frontend_status_label' => $order->getFrontendStatusLabel()
            ]
        ];
        
        
        
        //to farsi
        $transport['created_at_formatted'] = str_replace($farsiNums, $enNum, $transport['created_at_formatted']);
        
        $arr1 = explode('،', $transport['created_at_formatted']);
        $arr2 = explode('/', $arr1[0]);
        
        $arr3 = $this->_jalali->gregorianToJalali($arr2[0], $arr2[1], $arr2[2]);
        $strDate = implode('/', $arr3) . $arr1[1];
        $strDate = str_replace($enNum, $farsiNums, $strDate);
        
        $transport['created_at_formatted'] = $strDate;
                
        //to farsi end
        
        $transportObject = new DataObject($transport);

        /**
         * Event argument `transport` is @deprecated. Use `transportObject` instead.
         */
        $this->eventManager->dispatch(
            'email_order_set_template_vars_before',
            ['sender' => $this, 'transport' => $transportObject, 'transportObject' => $transportObject]
        );

        $this->templateContainer->setTemplateVars($transportObject->getData());

       // parent::prepareTemplate($order);
        $this->_parentOfParent->parentOfParentPrepareTemplate($order);
    }
    
}