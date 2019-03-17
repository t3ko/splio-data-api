<?php
namespace T3ko\SplioData;

use Http\Message\MessageFactory;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Api
{
    /**
     * @var string
     */
    private $universe;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * Api constructor.
     * @param string $universe
     * @param string $apiKey
     * @param ClientInterface $client
     * @param MessageFactory $messageFactory
     */
    public function __construct($universe, $apiKey, ClientInterface $client, MessageFactory $messageFactory)
    {
        $this->universe = $universe;
        $this->apiKey = $apiKey;
        $this->client = $client;
        $this->messageFactory = $messageFactory;
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * @return RequestInterface
     */
    private function prepareRequest($method, $resource, $body = '')
    {
        $baseUri = 'https://s3s.fr/api/data/1.9/';
        return $this->messageFactory->createRequest(
            $method,
            $baseUri.$resource,
            [
                'Authorization' =>
                sprintf('Basic %s', base64_encode(
                    sprintf('%s:%s', $this->universe, $this->apiKey)
                ))
            ],
            $body
        );
    }

    /**
     * @param RequestInterface $request
     * @throws UnauthorizedApiException
     * @throws NotFoundApiException
     * @return ResponseInterface
     */
    private function getResponse(RequestInterface $request)
    {
        $response = $this->client->sendRequest($request);
        if ($response->getStatusCode() == 401) {
            throw new UnauthorizedApiException();
        }
        if ($response->getStatusCode() == 404) {
            throw new NotFoundApiException();
        }
        return $response;
    }

    /**
     * Gets all contact lists
     *
     * @throws UnauthorizedApiException
     * @return ContactLists
     */
    public function getLists()
    {
        $request = $this->prepareRequest('GET', 'lists');
        $response = $this->getResponse($request);
        return $this->serializer->deserialize(
            (string) $response->getBody(),
            ContactLists::class,
            'json'
        );
    }

    /**
     * Gets all contact fields
     *
     * @throws UnauthorizedApiException
     * @return Fields
     */
    public function getFields()
    {
        $request = $this->prepareRequest('GET', 'fields');
        $response = $this->getResponse($request);
        return $this->serializer->deserialize(
            (string) $response->getBody(),
            Fields::class,
            'json'
        );
    }

    /**
     * Gets a specific contact
     *
     * @throws UnauthorizedApiException
     * @throws NotFoundApiException
     * @return Contact|null
     */
    public function getContact($identifier)
    {
        $request = $this->prepareRequest('GET', 'contact/'.$identifier);
        try {
            $response = $this->getResponse($request);
            return $this->serializer->deserialize(
                (string)$response->getBody(),
                Contact::class,
                'json'
            );
        } catch (NotFoundApiException $e) {
            return null;
        }
    }

    /**
     * Updates a specific contact
     *
     * @param Contact contact to update
     * @throws UnauthorizedApiException
     * @throws NotFoundApiException
     * @return Contact
     */
    public function addContact(Contact $contact)
    {
        $body = $this->serializer->serialize($contact, 'json');
        $request = $this->prepareRequest('POST', 'contact', $body);
        $response = $this->getResponse($request);
        return $this->serializer->deserialize(
            (string)$response->getBody(),
            Contact::class,
            'json'
        );
    }

    /**
     * Updates a specific contact
     *
     * @param Contact contact to update
     * @throws UnauthorizedApiException
     * @throws NotFoundApiException
     * @return Contact|null
     */
    public function updateContact(Contact $contact)
    {
        $body = $this->serializer->serialize($contact, 'json');
        $request = $this->prepareRequest('PUT', 'contact/'.$contact->getEmail(), $body);
        $response = $this->getResponse($request);
        return $this->serializer->deserialize(
            (string)$response->getBody(),
            Contact::class,
            'json'
        );
    }

    /**
     * Removes a specific contact
     *
     * @param Contact contact to update
     * @throws UnauthorizedApiException
     * @throws NotFoundApiException
     * @return boolean
     */
    public function removeContact(Contact $contact)
    {
        $request = $this->prepareRequest('DELETE', 'contact/'.$contact->getEmail());
        try {
            $response = $this->getResponse($request);
        } catch (NotFoundApiException $e) {
            return false;
        }
        if ($response->getStatusCode() == 200) {
            return true;
        }
    }

    /**
     * Checks if a specific contact is blacklisted
     *
     * @throws UnauthorizedApiException
     * @return boolean
     */
    public function isBlacklisted($identifier)
    {
        $request = $this->prepareRequest('GET', 'blacklist/'.$identifier);
        try {
            $response = $this->getResponse($request);
        } catch (NotFoundApiException $e) {
            return false;
        }
        if ($response->getStatusCode() == 200) {
            return true;
        }
    }
}