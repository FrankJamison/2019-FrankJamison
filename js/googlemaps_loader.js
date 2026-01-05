/*global window, document */

(function() {
    "use strict";

    var DEFAULT_API_KEY = "AIzaSyAe4lMKzstQOEegJCTSF7WZPyCScV40c9A";
    var MAPS_SCRIPT_ATTR = 'data-google-maps-loader';

    function getMetaApiKey() {
        var meta = document.querySelector('meta[name="google-maps-api-key"]');
        if (!meta) return "";
        var key = meta.getAttribute('content');
        return (key || "").trim();
    }

    function alreadyLoaded() {
        return typeof window.google !== 'undefined' && window.google && window.google.maps;
    }

    function alreadyInjected() {
        return !!document.querySelector('script[' + MAPS_SCRIPT_ATTR + ']');
    }

    function installAuthFailureHandler(apiKey) {
        var previous = window.gm_authFailure;
        window.gm_authFailure = function() {
            if (window.console && window.console.error) {
                window.console.error(
                    'Google Maps authentication failed (gm_authFailure). ' +
                    'This is almost always a key restriction/billing/API enablement problem. ' +
                    'Check the console for a "Google Maps JavaScript API error: ..." line. ' +
                    'Key used: ' + apiKey
                );
            }
            if (typeof previous === 'function') {
                try {
                    previous();
                } catch (e) {
                    // ignore
                }
            }
        };
    }

    function loadGoogleMaps() {
        if (alreadyLoaded()) return;
        if (alreadyInjected()) return;

        var apiKey = getMetaApiKey() || (window.GOOGLE_MAPS_API_KEY || "").trim() || DEFAULT_API_KEY;
        if (!apiKey) {
            if (window.console && window.console.warn) {
                window.console.warn('Google Maps API key missing. Set <meta name="google-maps-api-key" content="AIzaSyAe4lMKzstQOEegJCTSF7WZPyCScV40c9A"> or window.GOOGLE_MAPS_API_KEY before loading googlemaps_loader.js');
            }
            return;
        }

        installAuthFailureHandler(apiKey);

        var script = document.createElement('script');
        script.setAttribute(MAPS_SCRIPT_ATTR, '1');
        script.async = true;
        script.defer = true;
        script.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(apiKey) + '&callback=initMap&loading=async';
        script.onerror = function() {
            if (window.console && window.console.error) {
                window.console.error('Failed to load Google Maps JS API.');
            }
        };
        document.head.appendChild(script);
    }

    // Load after DOM is ready enough to read meta tags.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadGoogleMaps);
    } else {
        loadGoogleMaps();
    }
})();