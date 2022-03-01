<?php

declare(strict_types=1);

namespace App\Handler;

use App\User\LoggedUser;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Pheature\Core\Toggle\Read\FeatureFinder;
use Pheature\Core\Toggle\Read\Toggle;
use Pheature\Model\Toggle\Identity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PheaturePageHandler implements RequestHandlerInterface
{
    private FeatureFinder $featureFinder;
    private TemplateRendererInterface $templating;
    private Toggle $toggle;

    public function __construct(
        FeatureFinder $featureFinder,
        TemplateRendererInterface $templating,
        Toggle $toggle
    ) {
        $this->featureFinder = $featureFinder;
        $this->templating = $templating;
        $this->toggle = $toggle;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var LoggedUser|null $user */
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
                'roles' => $user->roles(),
            ]);
        }

        $isFeatureEnabled = $this->toggle->isEnabled('feature_section');
        $someFeatureSection = $this->toggle->isEnabled('some_feature_section');
        $workInProgressFeature = $this->toggle->isEnabled('work_in_progress');
        $showContactInformation = $this->toggle->isEnabled('show_contact_info', $identity);

        $template = $this->templating->render('app::index', [
            'all_features' => $this->featureFinder->all(),
            'feature_section' => $isFeatureEnabled,
            'some_feature_section' => $someFeatureSection,
            'work_in_progress_section' => $workInProgressFeature,
            'show_contact_information' => $showContactInformation,
        ]);

        return new HtmlResponse($template);
    }
}
