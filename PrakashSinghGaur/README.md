Introduction

This is an advaanced forum bundle using which you can create forums, each forum will have topics, each topic will have comments and then each comment may have replies.

This bundle requires IvoryCkeditor Bundle for presenting forms with good looking editor options. On installing this bundle IvoryCkeditor Bundle is also installed as a requirement but you have to configure it as given here http://symfony.com/doc/master/bundles/IvoryCKEditorBundle/installation.html  and here http://symfony.com/doc/master/bundles/IvoryCKEditorBundle/usage/config.html

This bundle strongly presumes the following:-
1. You are using Twitter Bootstrap and Font Awesome for your UI scheme. If not then you have to manage twig templates on your own. Otherwise, these will be looking ugly. Templates are inside /Resources/views/  folder
2. You have a user entity class called 'User'. Work is in progress to make this user entity configurable. But for the time being the default user entity class is User for referencing topics and comments to different users in the application.
3. The priviledge for creating new Forums may be given to a specific role e.g. Admin by making necessary access control entries in security.yml file and securing /forum path.
4. Authenticated users can post their topics in forums and comment on each others topics. Users can only edit and delete  their own topics and comments.



Installation

Download and install using composer require prakashsinghgaur/forum-bundle:dev-master

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

Please please.. do not forget to configure IvoryCkeditor bundle before start using this bundle. 