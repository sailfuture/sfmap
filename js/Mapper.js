Mapper = new function () {
    var self = this;
    this.map = null;
    this.posts = [];
    this.activePost = null;
    this.bounds = null;

    L.MakiMarkers.accessToken = "pk.eyJ1IjoiaHRob21wc28iLCJhIjoiLVhDOWJNcyJ9.6iETtw-YLSk5DqSDDpyKSg";

    var markerIcon = L.MakiMarkers.icon({
        icon: "star",
        color: "#0f0",
        size: "m"
    });

    var highLightIcon = L.MakiMarkers.icon({
        icon: "star",
        color: "#f00",
        size: "m"
    });


    this.init = function () {
        self.renderMap();
        self.addSpotTracker();
        self.getPosts(self.renderPosts);
    };


    this.renderMap = function () {
        L.mapbox.accessToken = 'pk.eyJ1IjoiaHRob21wc28iLCJhIjoiLVhDOWJNcyJ9.6iETtw-YLSk5DqSDDpyKSg';

        self.map = L.map('map', {
            center: [21.320545, -89.488685],
            zoom: 6
        });
        L.mapbox.styleLayer('mapbox://styles/hthompso/cj8hjpq0i27qn2rpqe6y2dzvg').addTo(self.map);
    };

    this.renderPosts = function () {
        var markers = [];
        self.posts.forEach(post => {
            post.marker = L.marker([post.latitude, post.longitude], {
                    icon: markerIcon
                })
                .addTo(self.map);
            post.marker.on('click', function () {
                self.showPost(post.id);
                self.highlightPost(post);
            });
            markers.push(post.marker);
        });
        var group = new L.featureGroup(markers);
        self.bounds = group.getBounds();
        self.map.flyToBounds(self.bounds);
    };

    this.handleShowPost = function (postID) {
        self.showPost(postID);
        var found = null;
        self.posts.forEach(post => {
            if (post.id == postID) {
                found = post;
            }
        });
        console.log(postID);
        console.log(found);
        found && self.highlightPost(found);
    }

    this.highlightPost = function (post) {
        if (self.activePost) {
            self.activePost.marker.setIcon(markerIcon);
        }
        self.activePost = post;
        post.marker.setIcon(highLightIcon);
        self.flyTo(post.latitude, post.longitude);
    };

    this.flyTo = function (latitude, longitude) {
        var latLng = L.latLng(latitude, longitude);
        var overlayWidth = $('#map').outerWidth();
        var ctrlPoint = self.map.latLngToContainerPoint(latLng);
        var targetPoint = ctrlPoint.subtract([(overlayWidth * 25 / 96), 0]);
        var targetLatLng = self.map.containerPointToLatLng(targetPoint);
        self.map.flyTo(targetLatLng);
    };

    this.removeHighlight = function () {
        if (self.activePost) {
            self.activePost.marker.setIcon(markerIcon);
        }
        self.activePost = null;
        self.map.flyToBounds(self.bounds);
    };

    this.showPost = function (postID) {
        self.closePost();
        $.ajax({
            url: ajaxcall.ajaxurl,
            type: 'post',
            data: {
                action: 'ajax_get_post_by_id',
                post_id: postID
            },
            success: function (html) {
                $('#place').empty();
                $('#place').html(html);
                $('#place').css({
                    'left': '0%',
                    'transition': '1s'
                });
            }
        });
    };

    this.closePost = function () {
        $('#place').css({
            'left': '100%',
            'transition': '1s'
        });
        self.removeHighlight();
    };

    this.getPosts = function (callback) {
        $.ajax({
            url: ajaxcall.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'ajax_get_all_posts'
            },
            success: function (posts) {
                posts.forEach(post => {
                    post.latitude = Number(post.latitude);
                    post.longitude = Number(post.longitude);
                    self.posts.push(post);
                });
                callback();
            }
        });
    };

    this.addSpotTracker = function () {
        L.spotTracker('0Ja4Ivs1BMTNaXf3R5ac3QJgWqtfIMUnt', {
            api: 'https://hthompso.carto.com/api/v2/sql',
            url: "{api}?q=SELECT * FROM mexicotrip_2018 WHERE feed_id='{feed}' ORDER BY timestamp",
            liveUrl: "{api}?q=SELECT * FROM spotted WHERE feed_id='{feed}' AND timestamp > {timestamp} ORDER BY timestamp",
            OK: {
                icon: L.MakiMarkers.icon({
                    icon: 'building',
                    color: '#145291',
                    size: 'm'
                }),
                title: 'Hytte'
            },
            CUSTOM: {
                icon: L.MakiMarkers.icon({
                    icon: 'campsite',
                    color: '#145291',
                    size: 'm'
                }),
                title: 'Telt'
            },
            onClick: function (evt) {
                var message = evt.message;
                evt.layer.bindPopup(getPlace(message) + getTime(message.timestamp) + getWeather(message)).openPopup();
            }
        }).addTo(self.map);
    };
};

$(document).ready(Mapper.init)