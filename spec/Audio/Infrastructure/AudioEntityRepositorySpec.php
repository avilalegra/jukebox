<?php

namespace spec\App\Audio\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;

class AudioEntityRepositorySpec extends ObjectBehavior
{
    function let(EntityManagerInterface $em)
    {
        $this->beConstructedWith($em);
    }

    function it_should_add_and_audio(EntityManagerInterface $em)
    {
        $this->add(sampleAudioEntity());
        $em->persist(sampleAudioEntity())->shouldHaveBeenCalled();
        $em->flush()->shouldHaveBeenCalled();
    }
}

