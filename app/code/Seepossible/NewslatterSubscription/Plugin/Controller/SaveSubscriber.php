<?php

namespace Seepossible\NewslatterSubscription\Plugin\Controller;

use Magento\Customer\Api\AccountManagementInterface as CustomerAccountManagement;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\Action\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Newsletter\Model\Subscriber;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Newsletter\Model\SubscriptionManagerInterface;
use Magento\Framework\Validator\EmailAddress as EmailValidator;
/**
 * Class NewAction
 */
class SaveSubscriber extends \Magento\Newsletter\Controller\Subscriber\NewAction
{
    /**
     * @var CustomerAccountManagement
     */
    protected $customerAccountManagement;

    protected $resultJsonFactory;

     private $emailValidator;

    /**
     * @var SubscriptionManagerInterface
     */

    private $subscriptionManager;

    /**
     * Initialize dependencies.
     *
     * @param Context $context
     * @param SubscriberFactory $subscriberFactory
     * @param Session $customerSession
     * @param StoreManagerInterface $storeManager
     * @param CustomerUrl $customerUrl
     * @param CustomerAccountManagement $customerAccountManagement
     * @param SubscriptionManagerInterface $subscriptionManager
     * @param EmailValidator $emailValidator
     */
    public function __construct(
        Context $context,
        SubscriberFactory $subscriberFactory,
        Session $customerSession,
        StoreManagerInterface $storeManager,
        CustomerUrl $customerUrl,
        CustomerAccountManagement $customerAccountManagement,
        SubscriptionManagerInterface $subscriptionManager,
        EmailValidator $emailValidator = null,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->customerAccountManagement = $customerAccountManagement;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct(
            $context,
            $subscriberFactory,
            $customerSession,
            $storeManager,
            $customerUrl,
            $customerAccountManagement,
            $subscriptionManager,
            $emailValidator
        );
    }

    /**
     * Retrieve available Order fields list
     *
     * @return array
     */
    public function aroundExecute($subject, $procede)
    {
        $response = [];
        if ($this->getRequest()->isPost() && $this->getRequest()->getPost('email')) {
            echo 'hii';
            die;
            $email = (string)$this->getRequest()->getPost('email');

            try {
                $this->validateEmailFormat($email);
                $this->validateGuestSubscription();
                $this->validateEmailAvailable($email);


                $websiteId = (int)$this->_storeManager->getStore()->getWebsiteId();
                
                $subscriber = $this->_subscriberFactory->create()->loadBySubscriberEmail($email, $websiteId);
                
                if ($subscriber->getId()
                    && (int)$subscriber->getSubscriberStatus() === Subscriber::STATUS_SUBSCRIBED) {
                     $response = [
                        'status' => 'OK',
                        'msg' => 'This email address is already subscribed.',
                    ];
                    return $this->resultJsonFactory->create()->setData($response);
                }

                $status = $this->_subscriberFactory->create()->subscribe($email);
               
                if ($status == Subscriber::STATUS_NOT_ACTIVE) {
                    $response = [
                        'status' => 'OK',
                        'msg' => 'The confirmation request has been sent.',
                    ];

                }else {
                    $response = [
                        'status' => 'OK',
                        'msg' => 'Thank you for your subscription.',
                    ];
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $response = [
                    'status' => 'ERROR',
                    'msg' => __('There was a problem with the subscription: %1', $e->getMessage()),
                ];
            } catch (\Exception $e) {
                $response = [
                    'status' => 'ERROR',
                    'msg' => __('Something went wrong with the subscription.'),
                ];
            }
        }

        return $this->resultJsonFactory->create()->setData($response);
    }
}