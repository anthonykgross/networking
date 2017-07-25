<?php
namespace Networking;


class IP
{
    const LOCAL_IPS = array('127.0.0.1', 'fe80::1', '::1');

    /**
     * @var string
     */
    private $ip;

    /**
     * @var bool
     */
    private $isValid;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $isReserved;

    /**
     * @var bool
     */
    private $isPrivate;

    /**
     * @var bool
     */
    private $isLocal;

    /**
     * IP constructor.
     * @param $ip
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
        $this->checkIp();
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isReserved()
    {
        return $this->isReserved;
    }

    /**
     * @return bool
     */
    public function isPrivate()
    {
        return $this->isPrivate;
    }

    protected function checkIp()
    {

        $this->isValid = (filter_var($this->ip, FILTER_VALIDATE_IP)?true:false);

        if ($this->isValid) {
            $this->type = (
                filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
            ) ? 'IPV6' : 'IPV4';
        }
        if ($this->isValid) {
            $this->isReserved = (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE)?true:false);
        }
        if ($this->isValid) {
            $this->isPrivate = (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)?true:false);
        }
        if ($this->ip) {
            $this->isLocal = in_array($this->ip, self::LOCAL_IPS);
        }
    }

    /**
     * @return bool
     */
    public function isLocal()
    {
        return $this->isLocal;
    }
}