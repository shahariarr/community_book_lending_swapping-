<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


function routeName($string)
{
    if (Str::contains($string, '.')) {
        $arr = explode('.', $string);
        $route = $arr[1] . '-' . str_split($arr[0], strlen($arr[0]) - 1)[0];
        return $route;
    }
    return $string;
}


function slug($string)
{
    $slug = Str::slug($string);
    $slug .= '-' . Str::random(5);
    return $slug;
}

if (!function_exists('getPlatformIcon')) {
    /**
     * Get the Font Awesome icon class for a social media platform
     *
     * @param string $platform The social platform identifier
     * @return string The Font Awesome icon class
     */
    function getPlatformIcon($platform)
    {
        $icons = [
            'linkedin' => 'fab fa-linkedin',
            'github' => 'fab fa-github',
            'facebook' => 'fab fa-facebook-f',
            'twitter' => 'fab fa-twitter',
            'instagram' => 'fab fa-instagram',
            'youtube' => 'fab fa-youtube',
            'pinterest' => 'fab fa-pinterest',
            'medium' => 'fab fa-medium',
            'behance' => 'fab fa-behance',
            'dribbble' => 'fab fa-dribbble',
            'whatsapp' => 'fab fa-whatsapp',
            'snapchat' => 'fab fa-snapchat',
            'tiktok' => 'fab fa-tiktok',
            'reddit' => 'fab fa-reddit',
            'tumblr' => 'fab fa-tumblr',
            'flickr' => 'fab fa-flickr',
            'quora' => 'fab fa-quora',
            'telegram' => 'fab fa-telegram',
            'discord' => 'fab fa-discord',
            'skype' => 'fab fa-skype',
            'viber' => 'fab fa-viber',
            'website' => 'fas fa-globe',
            'other' => 'fas fa-link'

        ];

        return $icons[$platform] ?? 'fas fa-link';
    }

    if (!function_exists('getSimplePlatformIcon')) {
        /**
         * Get the simple Font Awesome icon name (without fa- prefix) for use in fa fa-[name] format
         *
         * @param string $platform The social platform identifier
         * @return string The simple icon name
         */
        function getSimplePlatformIcon($platform)
        {
            $icons = [
                'linkedin' => 'fab fa-linkedin',
                'github' => 'fab fa-github',
                'facebook' => 'fab fa-facebook-f',
                'twitter' => 'fab fa-twitter',
                'instagram' => 'fab fa-instagram',
                'youtube' => 'fab fa-youtube',
                'pinterest' => 'fab fa-pinterest',
                'medium' => 'fab fa-medium',
                'behance' => 'fab fa-behance',
                'dribbble' => 'fab fa-dribbble',
                'whatsapp' => 'fab fa-whatsapp',
                'snapchat' => 'fab fa-snapchat',
                'tiktok' => 'fab fa-tiktok',
                'reddit' => 'fab fa-reddit',
                'tumblr' => 'fab fa-tumblr',
                'flickr' => 'fab fa-flickr',
                'quora' => 'fab fa-quora',
                'telegram' => 'fab fa-telegram',
                'discord' => 'fab fa-discord',
                'skype' => 'fab fa-skype',
                'viber' => 'fab fa-viber',
                'website' => 'fas fa-globe',
                'other' => 'fas fa-link'
            ];

            return $icons[$platform] ?? 'link';
        }
    }


    if (!function_exists('getSkillIcon')) {
        /**
         * Get the Font Awesome icon class for a skill
         *
         * @param string $skillName The skill name
         * @return string The Font Awesome icon class
         */
        function getSkillIcon($skillName)
        {
            $icons = [
                'HTML' => 'fab fa-html5',
                'CSS' => 'fab fa-css3-alt',
                'JavaScript' => 'fab fa-js',
                'TypeScript' => 'fab fa-js',
                'React' => 'fab fa-react',
                'Vue' => 'fab fa-vuejs',
                'Angular' => 'fab fa-angular',
                'Node.js' => 'fab fa-node-js',
                'Express' => 'fab fa-server',
                'PHP' => 'fab fa-php',
                'Laravel' => 'fab fa-laravel',
                'Python' => 'fab fa-python',
                'Django' => 'fab fa-python',
                'Ruby' => 'fab fa-gem',
                'Ruby on Rails' => 'fab fa-train',
                'Java' => 'fab fa-java',
                'Spring' => 'fab fa-leaf',
                'C#' => 'fab fa-microsoft',
                '.NET' => 'fab fa-windows',
                'C++' => 'fab fa-code',
                'MySQL' => 'fab fa-database',
                'PostgreSQL' => 'fab fa-database',
                'MongoDB' => 'fab fa-database',
                'Firebase' => 'fab fa-fire',
                'AWS' => 'fab fa-aws',
                'Azure' => 'fab fa-microsoft',
                'Google Cloud' => 'fab fa-google',
                'Docker' => 'fab fa-docker',
                'Kubernetes' => 'fab fa-dharmachakra',
                'Git' => 'fab fa-git-alt',
                'GitHub' => 'fab fa-github',
                'GitLab' => 'fab fa-gitlab',
                'Figma' => 'fab fa-figma',
                'Adobe XD' => 'fab fa-adobe',
                'Adobe Photoshop' => 'fab fa-adobe',
                'Adobe Illustrator' => 'fab fa-adobe',
                'UI/UX Design' => 'fab fa-paint-brush',
                'Responsive Design' => 'fab fa-mobile-alt',
                'WordPress' => 'fab fa-wordpress',
                'SEO' => 'fab fa-search',
                'Marketing' => 'fab fa-bullhorn',
                'Content Writing' => 'fab fa-pen',
                'Project Management' => 'fab fa-tasks',
                'Agile' => 'fab fa-sync',
                'Scrum' => 'fab fa-users',
            ];

            return $icons[$skillName] ?? 'fab fa-code';
        }
    }
}
