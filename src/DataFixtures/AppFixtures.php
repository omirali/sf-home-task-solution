<?php

namespace App\DataFixtures;

use App\Entity\Template;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //create mobile verification template
        $template = new Template();
        $template->setSlug('mobile-verification');
        $template->setContent('Your verification code is {{ code }}.');
        $manager->persist($template);

        //create email verification template
        $template = new Template();
        $template->setSlug('email-verification');
        $template->setContent('<!DOCTYPE html>
<html>
<head>
    <title>Email verification</title>
    <style>
        .content {
            margin: auto;
            width: 600px;
        }
    </style>
</head>
<body>
    <div class="content">
        <p>Your verification code is 1234.</p>
    </div>
</body>
</html>');
        $manager->persist($template);


        $manager->flush();
    }
}
