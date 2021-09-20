<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusElasticsearchPlugin\PropertyBuilder;

use BitBag\SyliusElasticsearchPlugin\Repository\TaxonRepositoryInterface;
use BitBag\SyliusElasticsearchPlugin\PropertyBuilder\AbstractBuilder;
use BitBag\SyliusElasticsearchPlugin\PropertyBuilder\AttributeTaxonsBuilder;
use BitBag\SyliusElasticsearchPlugin\PropertyBuilder\PropertyBuilderInterface;
use Elastica\Document;
use FOS\ElasticaBundle\Event\AbstractTransformEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Attribute\Model\AttributeInterface;

final class AttributeTaxonsBuilderSpec extends ObjectBehavior
{
    function let(TaxonRepositoryInterface $taxonRepository): void
    {
        $this->beConstructedWith(
            $taxonRepository,
            'taxons'
        );

        $taxonRepository->getTaxonsByAttributeViaProduct(Argument::any())->willReturn([]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(AttributeTaxonsBuilder::class);
        $this->shouldHaveType(AbstractBuilder::class);
    }

    function it_implements_property_builder_interface(): void
    {
        $this->shouldHaveType(PropertyBuilderInterface::class);
    }

    function it_consumes_event(AbstractTransformEvent $event, AttributeInterface $attribute, Document $document): void
    {
        $event->getObject()->willReturn($attribute);
        $event->getDocument()->willReturn($document);

        $document->set(Argument::any(), Argument::any())->willReturn($document);

        $this->consumeEvent($event);
    }
}
