Introduction

This is an advaanced forum bundle using which you can create forums, each forum will have topics, each topic will have comments and then each comment may have replies.

Installation

Download and install using composer require prakashsinghgaur/forum-bundle:@dev

Register the bundle in AppKernel in registerBundles():
new PrakashSinghGaur\ForumBundle\PrakashSinghGaurForumBundle(),

Import routing in routing.yml
prakash_singh_gaur_forum:
    resource: "@PrakashSinghGaurForumBundle/Controller/"
    type:     annotation
    prefix:   /

To create relevant  tables in the database run this console command from the root of your project
php app/console doctrine:schema::update --force


Usage

After installation, the journey will start from /forum url. From there you will find links for creating and editing various forum related content.


