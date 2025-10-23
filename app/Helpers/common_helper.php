<?php

function load_sidebar_menus($type)
{
    $data = [
        'main' => [
            [
                'name' => 'Home',
                'active' => 'home',
                'url' => base_url(),
            ],
            [
                'name' => 'About Us',
                'active' => 'about-us',
                'url' => base_url('about-us'),
            ],
            [
                'name' => 'Services',
                'active' => 'services',
                'url' => base_url('services'),
            ],
            [
                'name' => 'Pricing',
                'active' => 'pricing',
                'url' => base_url('pricing'),
            ],
            [
                'name' => 'Projects',
                'active' => 'projects',
                'url' => base_url('projects'),
            ],
            [
                'name' => 'Blog',
                'active' => 'blog',
                'url' => base_url('blog'),
            ],
            [
                'name' => 'Subsidy Info',
                'active' => 'subsidy-info',
                'url' => base_url('subsidy-info'),
            ],
            [
                'name' => 'Contact',
                'active' => 'contact',
                'url' => base_url('contact'),
            ]
        ],

        'admin' => [
            [
                'name' => 'Dashboard',
                'active' => 'dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'url' => ADMIN_URL . 'dashboard',
            ],
            [
                'name' => 'Blog Posts',
                'active' => 'blog-posts',
                'icon' => 'fas fa-blog',
                'url' => ADMIN_URL . 'blog-posts',
            ],
            [
                'name' => 'Projects',
                'active' => 'projects',
                'icon' => 'fas fa-tools',
                'url' => ADMIN_URL . 'projects',
            ],
            [
                'name' => 'Testimonials',
                'active' => 'testimonials',
                'icon' => 'fas fa-star',
                'url' => ADMIN_URL . 'testimonials',
            ],
            [
                'name' => 'Contact Leads',
                'active' => 'contact-leads',
                'icon' => 'fas fa-envelope',
                'url' => ADMIN_URL . 'contact-leads',
            ],
            [
                'name' => 'Pricing Packages',
                'active' => 'pricing-packages',
                'icon' => 'fas fa-rupee-sign',
                'url' => ADMIN_URL . 'pricing-packages',
            ],
            [
                'name' => 'Site Settings',
                'active' => 'site-settings',
                'icon' => 'fas fa-cog',
                'url' => ADMIN_URL . 'site-settings',
            ]
        ]
    ];

    return $data[$type];
}

function clean_text($input_array)
{
    $input_array = trim_inputs($input_array);
    if (is_array($input_array)) {
        foreach ($input_array as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $sub_key => $sub_value) {
                    $input_array[$key][$sub_key] = htmlentities(strip_tags($sub_value));
                }
            } else {
                $input_array[$key] = htmlentities(strip_tags($value));
            }
        }
        return $input_array;
    } else {
        return htmlentities(strip_tags($input_array));
    }
}

function trim_inputs($input)
{

    if (is_array($input)) {
        $new_array = array();
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $new_array[$key] = trim_inputs($value);
            } else {
                $new_array[$key] = trim($value);
            }
        }
        return $new_array;
    } else {
        return trim($input);
    }
}

function gen_uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

function randomString($length = 10)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function formatDate($date, $format = "m/d/Y")
{
    return date($format, strtotime($date));
}

function parseTemplate(string $text, array $data): string
{
    foreach ($data as $key => $value) {
        $text = str_replace('{{' . $key . '}}', $value, $text);
    }
    return $text;
}

function check_login()
{
    $session = session();
    if ($session->get('isLoggedIn')) {
        redirect()->to(base_url('babayaga/AST/admin/dashboard'))->send();
        die;
    }
}