<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/***************************************************Customer Routes*************************************************/
$auth = ['filter' => 'auth'];
$routes->get('/', 'Dashboard::index');
$routes->get('/about-us', 'AboutUs::index');
$routes->get('/services', 'Services::index');
$routes->get('/pricing', 'Pricing::index');
$routes->get('/projects', 'Projects::index');
$routes->get('/blog', 'Blog::index');
$routes->get('/blog-detail/(:any)', 'Blog::blog_detail/$1');
$routes->get('/subsidy-info', 'Subsidy::index');
$routes->get('/contact', 'Contact::index');
$routes->post('process-form', 'Dashboard::processForm');


$routes->group('babayaga/AST/admin', function ($routes) {
    $routes->get('', 'admin\Login::index');
    $routes->get('login', 'admin\Login::index');
    $routes->post('auth', 'admin\Login::auth');
});

$routes->group('babayaga/AST/admin', $auth, function ($routes) {
    /******************************* Login Route ************************************/
    $routes->get('logout', 'admin\Login::logout');

    /******************************* Dashboard Route ************************************/
    $routes->get('dashboard', 'admin\Dashboard::index');

    /******************************* BlogPost Route ************************************/
    $routes->get('blog-posts', 'admin\BlogPosts::index');
    $routes->get('add-blog-post', 'admin\BlogPosts::add_blog_post');
    $routes->post('save-blog-post', 'admin\BlogPosts::save_blog_post');
    $routes->get('edit-blog-post/(:any)', 'admin\BlogPosts::edit_blog_post/$1');
    $routes->post('update-blog-post', 'admin\BlogPosts::update_blog_post');
    $routes->post('delete-post', 'admin\BlogPosts::delete_post');

    /******************************* Project Routes ************************************/
    $routes->get('projects', 'admin\Projects::index');
    $routes->get('add-project', 'admin\Projects::add_project');
    $routes->post('save-project', 'admin\Projects::save_project');
    $routes->get('edit-project/(:any)', 'admin\Projects::edit_project/$1');
    $routes->post('update-project', 'admin\Projects::update_project');
    $routes->post('delete-project', 'admin\Projects::delete_project');

    /******************************* Testimonials Routes ************************************/
    $routes->get('testimonials', 'admin\Testimonials::index');
    $routes->get('add-testimonials', 'admin\Testimonials::add_testimonials');
    $routes->post('save-testimonials', 'admin\Testimonials::save_testimonials');
    $routes->get('edit-testimonials/(:any)', 'admin\Testimonials::edit_testimonials/$1');
    $routes->post('update-testimonials', 'admin\Testimonials::update_testimonials');
    $routes->post('delete-testimonials', 'admin\Testimonials::delete_testimonials');

   /******************************* ContactLead Routes ************************************/
    $routes->get('contact-leads', 'admin\ContactLeads::index');
    $routes->post('delete-contact', 'admin\ContactLeads::deleteContact');
    




    $routes->get('pricing-packages', 'admin\Pricing::index');
    $routes->post('update-pricing', 'admin\Pricing::update_pricing');

   /******************************* SiteSetting Routes ************************************/
    $routes->get('site-settings', 'admin\SiteSettings::index');
    $routes->post('update-settings', 'admin\SiteSettings::update_settings');

});