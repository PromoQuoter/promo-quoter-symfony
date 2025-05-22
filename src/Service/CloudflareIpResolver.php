<?php
declare(strict_types=1);

namespace App\Service;

use Karser\Recaptcha3Bundle\Services\IpResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class CloudflareIpResolver implements IpResolverInterface
{
    public function __construct(private IpResolverInterface $decorated, private RequestStack $requestStack)
    {
    }

    public function resolveIp(): ?string
    {
        return $this->doResolveIp() ?? $this->decorated->resolveIp();
    }

    private function doResolveIp(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        return $request?->server->get('HTTP_CF_CONNECTING_IP');
    }
}