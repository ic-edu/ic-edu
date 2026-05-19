<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { width: 100%; height: 100%; overflow: hidden; background: #f8fafc; }
        #map { width: 100%; height: 100%; }
    </style>
</head>
<body>
    <div id="map"></div>

    <script>
        var locations = {!! json_encode($locations) !!};

        var map = L.map('map').setView([-2.5, 117.5], 5);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 18
        }).addTo(map);

        var groups = {};
        locations.forEach(function(loc) {
            if (!loc.latitude || !loc.longitude) return;
            var key = (loc.city || 'Unknown') + '_' + loc.latitude + '_' + loc.longitude;
            if (!groups[key]) {
                groups[key] = {
                    lat: parseFloat(loc.latitude),
                    lng: parseFloat(loc.longitude),
                    city: loc.city || 'Unknown',
                    users: []
                };
            }
            groups[key].users.push(loc.name);
        });

        Object.values(groups).forEach(function(g) {
            var radius = Math.min(6 + g.users.length * 4, 28);
            L.circleMarker([g.lat, g.lng], {
                radius: radius,
                fillColor: '#3b82f6',
                color: '#1d4ed8',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.75
            }).addTo(map).bindPopup(
                '<div style="font-family:sans-serif;min-width:130px">' +
                '<b style="color:#1e3a8a;font-size:14px">' + g.city + '</b><br>' +
                '<span style="color:#64748b;font-size:12px">' + g.users.length + ' user(s)</span>' +
                '<hr style="margin:6px 0;border-color:#e2e8f0">' +
                '<div style="font-size:12px;color:#374151">' + g.users.slice(0, 5).join('<br>') +
                (g.users.length > 5 ? '<br>... +' + (g.users.length - 5) + ' more' : '') +
                '</div></div>'
            );
        });
    </script>
</body>
</html>
