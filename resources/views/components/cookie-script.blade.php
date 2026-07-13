@props(['type' => 'analytics'])

@php
    $cookie = request()->cookie('cookie_consent');
    $hasConsent = false;
    
    if ($cookie) {
        $consents = json_decode($cookie, true);
        if (is_array($consents) && isset($consents[$type]) && $consents[$type] === true) {
            $hasConsent = true;
        }
    }
@endphp

@if($hasConsent)
    {{ $slot }}
@endif
