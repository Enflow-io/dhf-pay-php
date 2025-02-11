<?php

namespace DHF\Pay;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DHFPay
{
    /**
     * @var Payments
     */
    protected $payments;

    /**
     * @var Transaction
     */
    protected $transactions;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @return Payments
     */
    public function payments(): Payments
    {
        return $this->payments;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(string $endpoint, string $token)
    {
        $this->endpoint = $endpoint;
        $this->token = $token;
        $this->payments = new Payments($this);
        $this->transactions = new Transaction($this);
        $this->client = new Client(['base_uri' => $this->endpoint]);
    }


    /**
     * @return Transaction
     */
    public function transaction(): Transaction
    {
        return $this->transactions;
    }

    /**
     * @param $method
     * @param $uri
     * @param $params
     * @return array
     * @throws GuzzleException
     */
    public function request($method, $uri, $body): array
    {

        $newresponse = $this->client->request(
            $method,
            $uri,
            [
                //'debug'=>true,
                'headers' =>
                [
                    'Authorization' => "Bearer {$this->token}"
                ],
                \GuzzleHttp\RequestOptions::JSON => $body
            ]
        )->getBody()->getContents();

        var_dump($newresponse);

        return json_decode( $newresponse, true );

    }

}
