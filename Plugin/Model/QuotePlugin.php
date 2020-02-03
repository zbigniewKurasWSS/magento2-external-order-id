<?php
namespace Wss\ExternalOrderId\Plugin\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validator\StringLength;
use Magento\Quote\Model\QuoteRepository;
use Magento\Checkout\Model\ShippingInformationManagement;
use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Wss\ExternalOrderId\Api\Data\OrderLinkInterfaceFactory;

class QuotePlugin
{

    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var StationaryStoresRepository
     */
    protected $cartId;

    /**
     * @var OrderLinkInterfaceFactory
     */
    private $orderLinkFactory;

    /**
     * @param QuoteRepository $quoteRepository
     * @param OrderLinkInterfaceFactory $orderLinkFactory
     */
    public function __construct(
        QuoteRepository $quoteRepository,
        OrderLinkInterfaceFactory $orderLinkFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->orderLinkFactory = $orderLinkFactory;
    }

    /**
     * @param ShippingInformationManagement $subject
     * @param string $cartId
     * @param ShippingInformationInterface $addressInformation
     * @throws LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagement $subject,
        string $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $return = [$cartId, $addressInformation];
        $this->cartId = $cartId;
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        $externalOrderId = $addressInformation->getShippingAddress()->getExtensionAttributes()->getExternalOrderId();
        if ($externalOrderId) {
            $lengthValidator = new StringLength(['max' => 40, 'encoding' => 'UTF-8']);
            if (!$lengthValidator->isValid($externalOrderId)) {
                throw new LocalizedException(__($lengthValidator->getMessages()[StringLength::TOO_LONG]));
            }
            $orderLink = $this->orderLinkFactory->create();
            $orderLink->load($quote->getId(), 'quote_id');
            $orderLink->setQuoteId($quote->getId());
            $orderLink->setValue($externalOrderId)->save();
        }

        return $return;
    }
}
