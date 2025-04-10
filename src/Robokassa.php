<?php

namespace Hiap\Robokassa;

use Hiap\Robokassa\Config\Config;
use Hiap\Robokassa\Request\RequestFacade;
use Hiap\Robokassa\Security\SignatureFacade;
use GuzzleHttp\Client;

/**
 * Class Robokassa
 * @package App\Util
 */
class Robokassa
{
    /** @var RequestFacade */
    public RequestFacade $request;

    public SignatureFacade $signature;

    /**
     * Robokassa constructor.
     * @param Config $config
     */
    public function __construct(protected Config $config)
    {
        $this->request = new RequestFacade($config, new Client());
        $this->signature = new SignatureFacade($config);
    }
}
