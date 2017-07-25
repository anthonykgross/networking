<?php
namespace Networking;

class Network
{
    const TRACEROUTE_PORT = 33434;

    /**
     * @var Host
     */
    private $host;
    /**
     * @var array
     */
    private $traceRouteHosts = array();

    /**
     * Ip constructor.
     * @param Host $host
     */
    public function __construct(Host $host)
    {
        $this->host = $host;
    }

    /**
     * @param int $maxHops
     * @return array
     */
    public function traceRoute($maxHops = 30)
    {
        $ttl = 1;
        while ($ttl <= $maxHops) {
            // Create ICMP and UDP sockets
            $recv_socket = socket_create(AF_INET, SOCK_RAW, getprotobyname('icmp'));
            $send_socket = socket_create(AF_INET, SOCK_DGRAM, getprotobyname('udp'));

            // Set TTL to current lifetime
            socket_set_option($send_socket, 0, 2, $ttl);

            // Bind receiving ICMP socket to default IP (no port needed since it's ICMP)
            socket_bind($recv_socket, 0, 0);

            // Save the current time for roundtrip calculation
            $t1 = microtime(true);

            // Send a zero sized UDP packet towards the destination
            socket_sendto($send_socket, "", 0, 0, $this->host->getIp(), self::TRACEROUTE_PORT);

            // Wait for an event to occur on the socket or timeout after 5 seconds. This will take care of the
            // hanging when no data is received (packet is dropped silently for example)
            $r = array($recv_socket);
            $w = $e = array();
            socket_select($r, $w, $e, 5, 0);

            $host = null;

            // Nothing to read, which means a timeout has occurred.
            if (count($r)) {
                // Receive data from socket (and fetch destination address from where this data was found)
                socket_recvfrom($recv_socket, $buf, 512, 0, $recv_addr, $recv_port);

                // Calculate the roundtrip time
                $roundtrip_time = (microtime(true) - $t1) * 1000;

                // No decent address found, display a * instead
                if (empty($recv_addr)) {
                    $recv_addr = "*";
                    $recv_name = "*";
                } else {
                    // Otherwise, fetch the hostname for the address found
                    $recv_name = gethostbyaddr($recv_addr);
                }

                // Print statistics
                $host = new Host();
                $host->setIp($recv_addr)
                    ->setDelay($roundtrip_time)
                    ->setDomain($recv_name);
            }

            $this->traceRouteHosts[$ttl] = $host;

            // Close sockets
            socket_close($recv_socket);
            socket_close($send_socket);

            // Increase TTL so we can fetch the next hop
            $ttl++;

            // When we have hit our destination, stop the traceroute
            if ($recv_addr == $this->host->getIp()) {
                break;
            }
        }
        return $this->traceRouteHosts;
    }
}