<?php
namespace Networking;

class Host
{
    /**
     * @var String
     */
    private $ip;
    /**
     * @var String
     */
    private $domain;
    /**
     * @var float
     */
    private $delay;

    /**
     * @return String
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param String $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return String
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param String $domain
     * @return $this
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return float
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param float $delay
     * @return $this
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;
        return $this;
    }

}