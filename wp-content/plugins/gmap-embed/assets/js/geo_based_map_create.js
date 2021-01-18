var map, marker1, infowindow, icon = 'https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png';

function _e(id) {
    return document.getElementById(id);
}

// Getting detailed address by lat,lng
function wpgmapSetAddressByLatLng(lat, lng) {
    jQuery.getJSON('https://maps.googleapis.com/maps/api/geocode/json?key=' + wp_gmap_api_key + '&latlng=' + lat + ',' + lng + '&sensor=true')
        .done(function (location) {
            if (location.status === 'OK') {
                _e('wpgmap_map_address').value = location.results[0].formatted_address;
            }
        })
        .fail(function (d) {
            console.log(d);
        })
        .always(function (d) {
            console.log(d);
        });

}

// Generating already initialized map
function generateAlreadyInitiztedMap(map_type, center_lat, center_lng) {
    if (map_type === 'ROADMAP') {
        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    } else if (map_type === 'SATELLITE') {
        map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
    } else if (map_type === 'HYBRID') {
        map.setMapTypeId(google.maps.MapTypeId.HYBRID);
    } else if (map_type === 'TERRAIN') {
        map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
    }

    map.setCenter({lat: center_lat, lng: center_lng});
    marker1 = new google.maps.Marker({
        position: new google.maps.LatLng(center_lat, center_lng),
        title: "",
        draggable: true,
        animation: google.maps.Animation.DROP
    });
    marker1.setMap(map);
    // Adding dragend Event Listener
    addMarkerDragendListener(marker1);
}

// Set map settings for by map Type
function setMapSettingsByMapType(map_type, center_lat, center_lng, zoom) {
    var gmap_settings = {
        center: {lat: center_lat, lng: center_lng},
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    if (map_type === 'ROADMAP') {
        gmap_settings.mapTypeId = google.maps.MapTypeId.ROADMAP;
    } else if (map_type === 'SATELLITE') {
        gmap_settings.mapTypeId = google.maps.MapTypeId.SATELLITE;
    } else if (map_type === 'HYBRID') {
        gmap_settings.mapTypeId = google.maps.MapTypeId.HYBRID;
    } else if (map_type === 'TERRAIN') {
        gmap_settings.mapTypeId = google.maps.MapTypeId.TERRAIN;
    }
    return gmap_settings;
}

function addMarkerDragendListener(marker) {
    marker.addListener('dragend', function (markerLocation) {
        _e("wpgmap_latlng").value = markerLocation.latLng.lat() + "," + markerLocation.latLng.lng();
        wpgmapSetAddressByLatLng(markerLocation.latLng.lat(), markerLocation.latLng.lng());
    });
}

// To render Google Map
function initAutocomplete(id, input, center_lat, center_lng, map_type, zoom) {

    // Set address by Lat Lng
    _e("wpgmap_latlng").value = center_lat + "," + center_lng;
    wpgmapSetAddressByLatLng(center_lat, center_lng);

    // In acse of already initiated map
    if (typeof map === 'object') {
        generateAlreadyInitiztedMap(map_type, center_lat, center_lng);
        return false;
    }

    // Set Map Settings by Map Type
    var gmap_settings = setMapSettingsByMapType(map_type, center_lat, center_lng, zoom);

    map = new google.maps.Map(_e(id), gmap_settings);
    marker1 = new google.maps.Marker({
        position: new google.maps.LatLng(center_lat, center_lng),
        title: "",
        draggable: true,
        animation: google.maps.Animation.DROP
    });
    // Add dragend event listener
    addMarkerDragendListener(marker1);
    marker1.setMap(map);

    // Create the search box and link it to the UI element.
    input = document.getElementById(input);
    var searchBox = new google.maps.places.SearchBox(input);
    google.maps.event.addDomListener(window, "load", function () {
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    });

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function () {
        marker1.setMap(null);
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }
        marker1.setMap(null);
        // Clear out the old markers.
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            // Create a marker for each place.
            marker1 = new google.maps.Marker({
                map: map,
                title: place.name,
                draggable: true,
                position: place.geometry.location,
                icon: icon
            });
            markers.push(marker1);
            openInfoWindow();
            marker1.position = place.geometry.location;

            // Add Marker event listener
            addMarkerDragendListener(marker1);

            _e('wpgmap_map_address').value = place.formatted_address;
            _e("wpgmap_latlng").value = place.geometry.location.lat() + "," + place.geometry.location.lng();

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);

        // Add Marker event listener
        addMarkerDragendListener(markers[0]);
    });

}

function openInfoWindow() {
    if (jQuery('#wpgmap_show_infowindow').is(':checked')) {
        var gmap_embed_address = jQuery("#wpgmap_map_address").val();
        infowindow = new google.maps.InfoWindow({
            content: gmap_embed_address
        });
        infowindow.open(map, marker1);
    } else {
        if (infowindow !== undefined) {
            infowindow.close();
        }
    }
}

// Initialize Map
function initWpGmap(lat, lng, map_type) {
    initAutocomplete('map', 'pac-input', lat, lng, map_type, parseInt(_e('wpgmap_map_zoom').value));
}


var tryAPIGeolocation = function () {
    jQuery.post("https://www.googleapis.com/geolocation/v1/geolocate?key=" + wp_gmap_api_key, function (success) {
        initWpGmap(success.location.lat, success.location.lng, 'ROADMAP');
    })
        .fail(function (err) {
            console.log("API Geolocation error! \n\n" + err);
        });
};
var browserGeolocationSuccess = function (position) {
    initWpGmap(position.coords.latitude, position.coords.longitude, 'ROADMAP');
};

var browserGeolocationFail = function (error) {
    switch (error.code) {
        case error.TIMEOUT:
            console.log("Browser geolocation error !\n\nTimeout.");
            initWpGmap(40.73359922990751, -74.02791395625002, 'ROADMAP');
            break;
        case error.PERMISSION_DENIED:
            tryAPIGeolocation();
            break;
        case error.POSITION_UNAVAILABLE:
            console.log("Browser geolocation error !\n\nPosition unavailable.");
            initWpGmap(40.73359922990751, -74.02791395625002, 'ROADMAP');
            break;

    }
};

var tryGeolocation = function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            browserGeolocationSuccess,
            browserGeolocationFail,
            {maximumAge: 50000, timeout: 20000, enableHighAccuracy: true});
    } else {
        initWpGmap(40.73359922990751, -74.02791395625002, 'ROADMAP');
    }
};


// ========================Show in marker infowindow Toggle=========================
jQuery('#wpgmap_show_infowindow').click('change', function (element) {
    openInfoWindow();
});

// ========================Zoom level change =========================
jQuery(document.body).find('#wpgmap_map_zoom').on('keyup', function (element) {
    var point = marker1.getPosition(); // Get marker position
    map.panTo(point); // Pan map to that position
    var current_zoom = parseInt(document.getElementById('wpgmap_map_zoom').value);
    setTimeout("map.setZoom(" + current_zoom + ")", 800); // Zoom in after 500 m second
});

// ========================On address field text change=========================
jQuery(document.body).find('#wpgmap_map_address').on('keyup', function (element) {
    infowindow.setContent(jQuery(this).val());
});

// ========================On address field text change=========================
jQuery(document.body).find('#wpgmap_title').on('keyup', function (element) {
    // if (jQuery('#wpgmap_show_heading').is(':checked')) {
    jQuery('#wpgmap_heading_preview').css({'display': 'block'}).html(jQuery('#wpgmap_title').val());
    // }
});

// ========================On address field text change=========================
jQuery(document.body).find('#wpgmap_map_type').on('change', function (element) {
    var map_type = jQuery(this).val();
    initWpGmap(marker1.position.lat(), marker1.position.lng(), map_type);
});

jQuery(document.body).find('.wpgmap_tab li').on('click', function (e) {
    e.preventDefault();
    jQuery('.wpgmap_tab li').removeClass('active');
    jQuery(this).addClass('active');

    jQuery('.wp-gmap-tab-contents').addClass('hidden');
    var wpgmap_id = jQuery(this).attr('id');
    jQuery('.' + wpgmap_id).removeClass('hidden');
});


// ========================================For Media Upload===================================
jQuery(document).ready(function ($) {

    $('#upload_image_button').click(function () {

        formfield = $('#upload_image').attr('name');
        tb_show('Upload your marker image', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            icon = $(html).attr('src');
            $('#wpgmap_upload_hidden').val(icon);
            tb_remove();
            marker1.setIcon(icon);
            jQuery("#wpgmap_icon_img").attr('src', icon);
        };
        return false;
    });
});

tryGeolocation();