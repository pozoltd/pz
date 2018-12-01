<?php
//Last updated: 2018-12-01 11:31:38
namespace Pz\Orm\Generated;

use Pz\Axiom\Walle;

class Order extends Walle
{
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $title;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $promoCode;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $promoCodeId;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $discount;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $subtotal;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $gst;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $total;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingFirstname;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingLastname;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingAddress;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingAddress2;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingSuburb;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingCity;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingPostcode;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingCountry;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $shippingSave;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $Note;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingSame;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingFirstname;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingLastname;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingAddress;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingAddress2;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingSuburb;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingCity;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingPostcode;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingCountry;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $billingSave;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $email;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $emailContent;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $customerId;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $status;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $payRequest;
    
    /**
     * #pz text COLLATE utf8mb4_unicode_ci DEFAULT NULL
     */
    private $payResponse;
    
    /**
     * #pz datetime DEFAULT NULL
     */
    private $payDate;
    
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param mixed title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * @return mixed
     */
    public function getPromoCode()
    {
        return $this->promoCode;
    }
    
    /**
     * @param mixed promoCode
     */
    public function setPromoCode($promoCode)
    {
        $this->promoCode = $promoCode;
    }
    
    /**
     * @return mixed
     */
    public function getPromoCodeId()
    {
        return $this->promoCodeId;
    }
    
    /**
     * @param mixed promoCodeId
     */
    public function setPromoCodeId($promoCodeId)
    {
        $this->promoCodeId = $promoCodeId;
    }
    
    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }
    
    /**
     * @param mixed discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }
    
    /**
     * @return mixed
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }
    
    /**
     * @param mixed subtotal
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }
    
    /**
     * @return mixed
     */
    public function getGst()
    {
        return $this->gst;
    }
    
    /**
     * @param mixed gst
     */
    public function setGst($gst)
    {
        $this->gst = $gst;
    }
    
    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    /**
     * @param mixed total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
    
    /**
     * @return mixed
     */
    public function getShippingFirstname()
    {
        return $this->shippingFirstname;
    }
    
    /**
     * @param mixed shippingFirstname
     */
    public function setShippingFirstname($shippingFirstname)
    {
        $this->shippingFirstname = $shippingFirstname;
    }
    
    /**
     * @return mixed
     */
    public function getShippingLastname()
    {
        return $this->shippingLastname;
    }
    
    /**
     * @param mixed shippingLastname
     */
    public function setShippingLastname($shippingLastname)
    {
        $this->shippingLastname = $shippingLastname;
    }
    
    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }
    
    /**
     * @param mixed shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }
    
    /**
     * @return mixed
     */
    public function getShippingAddress2()
    {
        return $this->shippingAddress2;
    }
    
    /**
     * @param mixed shippingAddress2
     */
    public function setShippingAddress2($shippingAddress2)
    {
        $this->shippingAddress2 = $shippingAddress2;
    }
    
    /**
     * @return mixed
     */
    public function getShippingSuburb()
    {
        return $this->shippingSuburb;
    }
    
    /**
     * @param mixed shippingSuburb
     */
    public function setShippingSuburb($shippingSuburb)
    {
        $this->shippingSuburb = $shippingSuburb;
    }
    
    /**
     * @return mixed
     */
    public function getShippingCity()
    {
        return $this->shippingCity;
    }
    
    /**
     * @param mixed shippingCity
     */
    public function setShippingCity($shippingCity)
    {
        $this->shippingCity = $shippingCity;
    }
    
    /**
     * @return mixed
     */
    public function getShippingPostcode()
    {
        return $this->shippingPostcode;
    }
    
    /**
     * @param mixed shippingPostcode
     */
    public function setShippingPostcode($shippingPostcode)
    {
        $this->shippingPostcode = $shippingPostcode;
    }
    
    /**
     * @return mixed
     */
    public function getShippingCountry()
    {
        return $this->shippingCountry;
    }
    
    /**
     * @param mixed shippingCountry
     */
    public function setShippingCountry($shippingCountry)
    {
        $this->shippingCountry = $shippingCountry;
    }
    
    /**
     * @return mixed
     */
    public function getShippingSave()
    {
        return $this->shippingSave;
    }
    
    /**
     * @param mixed shippingSave
     */
    public function setShippingSave($shippingSave)
    {
        $this->shippingSave = $shippingSave;
    }
    
    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->Note;
    }
    
    /**
     * @param mixed Note
     */
    public function setNote($Note)
    {
        $this->Note = $Note;
    }
    
    /**
     * @return mixed
     */
    public function getBillingSame()
    {
        return $this->billingSame;
    }
    
    /**
     * @param mixed billingSame
     */
    public function setBillingSame($billingSame)
    {
        $this->billingSame = $billingSame;
    }
    
    /**
     * @return mixed
     */
    public function getBillingFirstname()
    {
        return $this->billingFirstname;
    }
    
    /**
     * @param mixed billingFirstname
     */
    public function setBillingFirstname($billingFirstname)
    {
        $this->billingFirstname = $billingFirstname;
    }
    
    /**
     * @return mixed
     */
    public function getBillingLastname()
    {
        return $this->billingLastname;
    }
    
    /**
     * @param mixed billingLastname
     */
    public function setBillingLastname($billingLastname)
    {
        $this->billingLastname = $billingLastname;
    }
    
    /**
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }
    
    /**
     * @param mixed billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }
    
    /**
     * @return mixed
     */
    public function getBillingAddress2()
    {
        return $this->billingAddress2;
    }
    
    /**
     * @param mixed billingAddress2
     */
    public function setBillingAddress2($billingAddress2)
    {
        $this->billingAddress2 = $billingAddress2;
    }
    
    /**
     * @return mixed
     */
    public function getBillingSuburb()
    {
        return $this->billingSuburb;
    }
    
    /**
     * @param mixed billingSuburb
     */
    public function setBillingSuburb($billingSuburb)
    {
        $this->billingSuburb = $billingSuburb;
    }
    
    /**
     * @return mixed
     */
    public function getBillingCity()
    {
        return $this->billingCity;
    }
    
    /**
     * @param mixed billingCity
     */
    public function setBillingCity($billingCity)
    {
        $this->billingCity = $billingCity;
    }
    
    /**
     * @return mixed
     */
    public function getBillingPostcode()
    {
        return $this->billingPostcode;
    }
    
    /**
     * @param mixed billingPostcode
     */
    public function setBillingPostcode($billingPostcode)
    {
        $this->billingPostcode = $billingPostcode;
    }
    
    /**
     * @return mixed
     */
    public function getBillingCountry()
    {
        return $this->billingCountry;
    }
    
    /**
     * @param mixed billingCountry
     */
    public function setBillingCountry($billingCountry)
    {
        $this->billingCountry = $billingCountry;
    }
    
    /**
     * @return mixed
     */
    public function getBillingSave()
    {
        return $this->billingSave;
    }
    
    /**
     * @param mixed billingSave
     */
    public function setBillingSave($billingSave)
    {
        $this->billingSave = $billingSave;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param mixed email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * @return mixed
     */
    public function getEmailContent()
    {
        return $this->emailContent;
    }
    
    /**
     * @param mixed emailContent
     */
    public function setEmailContent($emailContent)
    {
        $this->emailContent = $emailContent;
    }
    
    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }
    
    /**
     * @param mixed customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }
    
    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * @param mixed status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * @return mixed
     */
    public function getPayRequest()
    {
        return $this->payRequest;
    }
    
    /**
     * @param mixed payRequest
     */
    public function setPayRequest($payRequest)
    {
        $this->payRequest = $payRequest;
    }
    
    /**
     * @return mixed
     */
    public function getPayResponse()
    {
        return $this->payResponse;
    }
    
    /**
     * @param mixed payResponse
     */
    public function setPayResponse($payResponse)
    {
        $this->payResponse = $payResponse;
    }
    
    /**
     * @return mixed
     */
    public function getPayDate()
    {
        return $this->payDate;
    }
    
    /**
     * @param mixed payDate
     */
    public function setPayDate($payDate)
    {
        $this->payDate = $payDate;
    }
    
}