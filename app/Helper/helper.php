<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

function AppLang(){
    return app()->getLocale();
}

function UrlLang($url){
    return url(AppLang().'/'.$url);
}

function AppDir(){
    return app()->getLocale() == 'ar' ? 'rtl' : 'ltr';
}

function switchLang($lang){
    return LaravelLocalization::getLocalizedURL($lang, null, [], true);
}

function SupportedLangs(){
    return LaravelLocalization::getSupportedLocales();
}

function LangDir($lang){
    return $lang == 'ar' ? 'rtl' : 'ltr';
}

function LangNative($lang){
    return LaravelLocalization::getSupportedLocales()[$lang]['native'];
}
