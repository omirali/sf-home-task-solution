<?php

namespace App\Infrastructure\Services;

use App\Domain\Template\Entity\Template;
use App\Domain\Template\ObjectValue\Content;
use App\Domain\Template\ObjectValue\Variables;
use App\Infrastructure\Dto\TemplateDto;
use App\Infrastructure\Dto\TemplateVariablesDto;
use App\Infrastructure\Repository\TemplateRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class TemplateService
{
    /**
     * @var TemplateRepository
     */
    private $repository;

    public function __construct(TemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function render(TemplateDto $templateDto)
    {
        $template = $this->getParsedTemplate($templateDto->slug, $templateDto->variables);

        $twig = (new Environment(new ArrayLoader()))->createTemplate($template->getContent()->getContent());
        return $twig->render(
            array_merge($template->getVariables()->toArray(), [
                'slug' => $template->getSlug()
            ])
        );
    }

    protected function getParsedTemplate($slug, $variables): Template
    {
        $content = $this->repository->findTemplateBySlug($slug);
        if (!$content) {
            throw new NotFoundHttpException();
        }
        return new Template(
            $slug,
            new Content($content->getContent()),
            new Variables(TemplateVariablesDto::fromArray($variables)->code)
        );
    }
}