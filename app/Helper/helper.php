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

function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}
