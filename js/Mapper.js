Mapper = new function () {
    var self = this;
    this.map = null;
    this.posts = [];
    this.activePost = null;
    this.bounds = null;

    L.MakiMarkers.accessToken = "pk.eyJ1IjoiaHRob21wc28iLCJhIjoiLVhDOWJNcyJ9.6iETtw-YLSk5DqSDDpyKSg";

    var once = true;
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
        if (self.isMobile()) return;
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
        var targetPoint = ctrlPoint.add([(overlayWidth * 0.3), 0]);
        var targetLatLng = self.map.containerPointToLatLng(targetPoint);
        self.map.flyTo(targetLatLng, 10);
        if (once) {
            once = false;
            setTimeout(() => {
                self.flyTo(latitude, longitude);
            }, 2000);
        }
    };

    this.removeHighlight = function () {
        if (self.isMobile()) return;
        if (self.activePost) {
            self.activePost.marker.setIcon(markerIcon);
        }
        self.activePost = null;
        self.map.flyToBounds(self.bounds);
    };

    this.isMobile = function () {
        var check = false;
        (function (a) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    };

    this.showPost = function (postID) {
        if (!postID) return;
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
                $('#place').addClass('active');
            }
        });
    };

    this.closePost = function () {
        $('#place').removeClass('active');
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
            url: "{api}?q=SELECT * FROM spotted WHERE feed_id='{feed}' ORDER BY timestamp",
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