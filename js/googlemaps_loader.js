/*global window, document */

(function() {
    "use strict";

    function getMetaApiKey() {
        var meta = document.querySelector('meta[name="google-maps-api-key"]');
        if (!meta) return "";
        var key = meta.getAttribute('content');
        return (key || "").trim();
    }

    function alreadyLoaded() {
        return typeof window.google !== 'undefined' && window.google && window.google.maps;
    }

    function loadGoogleMaps() {
        if (alreadyLoaded()) return;

        var apiKey = getMetaApiKey() || (window.GOOGLE_MAPS_API_KEY || "").trim();
        if (!apiKey) {
            if (window.console && window.console.warn) {
                window.console.warn('Google Maps API key missing. Set <meta name="google-maps-api-key" content="..."> or window.GOOGLE_MAPS_API_KEY before loading googlemaps_loader.js');
            }
            return;
        }

        var script = document.createElement('script');
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