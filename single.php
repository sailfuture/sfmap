<!DOCTYPE html>
<head>
    <meta charset=utf-8 />
    <title>Tiles Map</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

    <link href='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cartodb-libs.global.ssl.fastly.net/cartodb.js/v3/3.15/themes/css/cartodb.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        #map {
            position:absolute;
            top:0;
            bottom:0;
            width:100%;
        }
    </style>
</head>

<body>

    </head>
    <div id='map'></div>

   <!--  Important:  Both mapbox.js and cartodb.js use Leaflet, so loading both libraries would load leaflet twice and cause problems.  Mapbox has a "standalone" version of their library that does not inlude leaflet, so in this scenario we are using leaflet provided by cartodb.js -->
    <script src="https://cartodb-libs.global.ssl.fastly.net/cartodb.js/v3/3.15/cartodb.uncompressed.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox.js/v2.2.1/mapbox.standalone.js'></script>
    <script>
        L.mapbox.accessToken = 'pk.eyJ1Ijoic3ZwdmVydGV4IiwiYSI6IkxuUklIQUEifQ.VlwL0B5MUZcEqU-XsV8TVQ';

        var map = L.map('map', {
            center: [51.505537, -0.115528],
            zoom: 12
        });

        map.addControl(L.mapbox.geocoderControl('mapbox.places', {
            keepOpen: true
        }));

        var layers = {
            Streets: L.mapbox.tileLayer('svpvertex.ml8nijl4'),
            Imagery: L.mapbox.tileLayer('svpvertex.m0ammo9e')
        };

        layers.Streets.addTo(map);

        //add cartoDB layer, set z-index so it shows up on top
        cartodb.createLayer(map, 'https://svpvertex.cartodb.com/api/v2/viz/2a795afa-208c-11e5-ada2-0e4fddd5de28/viz.json').addTo(map)
        .on('done', function(layer) {
            layer.setZIndex(5);
        });

        L.control.layers(layers).addTo(map);

        var mapconfig = {
  "version": "0.0.1",
  "name": "mexicotrip_2018",
  "auth": {
    "method": "open"
  },
  "layergroup": {
    "layers": [{
      "type": "mapnik",
      "options": {
        "cartocss_version": "2.1.1",
        "cartocss": "#layer { polygon-fill: #FFF; }",
      }
    }]
  }
}

        $.ajax({
          crossOrigin: true,
          type: 'POST',
          dataType: 'json',
          contentType: 'application/json',
          url: 'https://hthompso.carto.com/api/v1/map',
          data: JSON.stringify(mapconfig),
          success: function(data) {
            var templateUrl = 'https://hthompso.carto.com/api/v1/map/' + data.layergroupid + '/{z}/{x}/{y}.png'
            console.log(templateUrl);
          }
        })


    </script>
</body>
