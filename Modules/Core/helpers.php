<?php

use Spatie\Valuestore\Valuestore;

// Get Setting Values
if (!function_exists('setting')) {

    function setting($key,$index = null) {
        $value = null;
        $setting = Valuestore::make(storage_path('app/settings.json'));

        if (!is_null($index)){

          if ($setting->get($key)) {
            $value = array_key_exists($index,$setting->get($key)) ? $setting->get($key)[$index] : null;
          }

        }else{

          $value = $setting->has($key) ? $setting->get($key) : null;

        }


        return $value ? $value : null;
    }
}

// Active Dashboard Menu
if (! function_exists('active_menu')) {

    function active_menu($route){
        return (Route::currentRouteName() == $route) ? 'active' : '';
    }

}


// GET THE CURRENT LOCALE
if (! function_exists('locale')) {

    function locale() {
        return app()->getLocale();
    }

}

// CHECK IF CURRENT LOCALE IS RTL
if (! function_exists('is_rtl')) {

    function is_rtl($locale = null) {

        $locale = ($locale == null) ? locale() : $locale;

        if (in_array($locale, config('rtl_locales'))) {
          return 'rtl';
        }

        return 'ltr';
    }

}


if (! function_exists('slugfy')) {
    /**
     * The Current dir
     *
     * @param string $locale
     */
     function slugfy($string, $separator = '-')
     {
         $url = trim($string);
         $url = strtolower($url);
         $url = preg_replace('|[^a-z-A-Z\p{Arabic}0-9 _]|iu', '', $url);
         $url = preg_replace('/\s+/', ' ', $url);
         $url = str_replace(' ', $separator, $url);

         return $url;
     }
}


if (! function_exists('path_without_domain')) {
    /**
     * Get Path Of File Without Domain URL
     *
     * @param string $locale
     */
    function path_without_domain($path)
    {
        $url = $path;
        $parts = explode("/",$url);
        array_shift($parts);
        array_shift($parts);
        array_shift($parts);
        $newurl = implode("/",$parts);

        return $newurl;
    }
}

if (! function_exists('int_to_array')) {
    /**
     * convert a comma separated string of numbers to an array
     *
     * @param string $integers
     */
    function int_to_array($integers)
    {
        return array_map("intval", explode(",", $integers));
    }
}

if (!function_exists('htmlView')) {
    /**
     * Access the OrderStatus helper.
     */
     function htmlView($content)
     {
         return
         '<!DOCTYPE html>
           <html lang="en">
             <head>
               <meta charset="utf-8">
               <meta http-equiv="X-UA-Compatible" content="IE=edge">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link href="css/bootstrap.min.css" rel="stylesheet">
               <!--[if lt IE 9]>
                 <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
               <![endif]-->
             </head>
             <body>
               '.$content.'
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
               <script src="js/bootstrap.min.js"></script>
             </body>
           </html>';
     }
}
