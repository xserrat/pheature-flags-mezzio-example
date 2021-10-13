<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Pheature\Core\Toggle\Read\Toggle;
use Pheature\Model\Toggle\Identity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PheaturePageHandler implements RequestHandlerInterface
{
    private TemplateRendererInterface $templating;
    private Toggle $toggle;

    public function __construct(TemplateRendererInterface $templating, Toggle $toggle)
    {
        $this->templating = $templating;
        $this->toggle = $toggle;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute('user');

        // Generate an identity based on any requirements
        if (null === $user) {
            $identity = new Identity('anon', [
                'location' => $request->getQueryParams()['location'] ?? 'unknown',
                'role' => 'IS_AUTHENTICATED_ANONYMOUSLY'
            ]);
        } else {
            $identity = new Identity($user->id(), [
                'location' => $user->location(),
                'role' => $user->role(),
            ]);
        }

        $isFeatureEnabled = $this->toggle->isEnabled('feature');
        $isSomeFeatureEnabled = $this->toggle->isEnabled('some_feature', $identity);
        $isInProgressFeatureEnabled = $this->toggle->isEnabled('in_progress_feature', $identity);

        $template = $this->templating->render('app::index', [
            'feature_section' => $isFeatureEnabled,
            'some_feature_section' => $isSomeFeatureEnabled,
            'in_progress_feature_section' => $isInProgressFeatureEnabled,
        ]);

        return new HtmlResponse($template);
    }
}
