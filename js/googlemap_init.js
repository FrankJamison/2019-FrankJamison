/*global google */

(function() {
    "use strict";

    var pendingInits = [];

    function normalizeAddress(address) {
        if (address == null) return "";
        return String(address).trim();
    }

    function getDefaultAddressFromPage() {
        var addressEl = document.getElementById('address');
        if (addressEl && addressEl.innerHTML) {
            return normalizeAddress(addressEl.innerHTML);
        }
        return "Washington";
    }

    function createMap(mapEl) {
        return new google.maps.Map(mapEl, {
            zoom: 8,
            center: {
                lat: -34.397,
                lng: 150.644
            }
        });
    }

    function geocodeAndPlaceMarker(map, address) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address: address
        }, function(results, status) {
            if (status === 'OK' && results && results[0] && results[0].geometry) {
                map.setCenter(results[0].geometry.location);
                new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                // Keep this non-blocking: the rest of the page should still work.
                if (window && window.console && window.console.warn) {
                    window.console.warn('Google Maps geocode failed:', status, address);
                }
            }
        });
    }

    function canUseGoogleMaps() {
        return typeof google !== 'undefined' && google && google.maps;
    }

    function runInit(mapEl, address) {
        if (!mapEl) return;

        // If the map container is inside a collapsed accordion/section,
        // Google Maps may render blank. Delay initialization until visible.
        var w = mapEl.offsetWidth || 0;
        var h = mapEl.offsetHeight || 0;
        if (w === 0 || h === 0) {
            var attempts = Number(mapEl.getAttribute('data-gmap-attempts') || '0');
            if (attempts < 40) { // ~10s at 250ms
                mapEl.setAttribute('data-gmap-attempts', String(attempts + 1));
                setTimeout(function() {
                    runInit(mapEl, address);
                }, 250);
            }
            return;
        }

        var map = mapEl.__googleMapInstance || createMap(mapEl);
        mapEl.__googleMapInstance = map;
        var normalized = normalizeAddress(address) || getDefaultAddressFromPage();
        if (normalized) {
            geocodeAndPlaceMarker(map, normalized);
        }

        // If it was initialized while transitioning to visible, force a resize.
        if (google && google.maps && google.maps.event && google.maps.event.trigger) {
            google.maps.event.trigger(map, 'resize');
        }
    }

    // ThemeREX theme expects this global.
    window.googlemap_init = function(mapEl, address) {
        if (!mapEl) return;
        if (!canUseGoogleMaps()) {
            pendingInits.push({
                mapEl: mapEl,
                address: address
            });
            return;
        }
        runInit(mapEl, address);
    };

    // Google Maps script callback expects this global.
    window.initMap = function() {
        // Drain any queued theme init calls first.
        if (canUseGoogleMaps() && pendingInits.length) {
            while (pendingInits.length) {
                var item = pendingInits.shift();
                runInit(item.mapEl, item.address);
            }
            return;
        }

        // Fallback for pages that use a "map" element (older demo code).
        var mapEl = document.getElementById('sc_googlemap') || document.getElementById('map');
        if (!mapEl || !canUseGoogleMaps()) return;

        var address = getDefaultAddressFromPage();
        runInit(mapEl, address);
    };
})();