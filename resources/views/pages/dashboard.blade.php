@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])

@section('content')
<style>
/**
       * @license
       * Copyright 2019 Google LLC. All Rights Reserved.
       * SPDX-License-Identifier: Apache-2.0
       */
/**
       * Always set the map height explicitly to define the size of the div element
       * that contains the map.
       */
#map {
    height: 100%;
}

/* Optional: Makes the sample page fill the window. */
html,
body {
    height: 100%;
    margin: 0;
    padding: 0;
}

.custom-map-control-button {
    background-color: #fff;
    border: 0;
    border-radius: 2px;
    box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
    margin: 10px;
    padding: 0 0.5em;
    font: 400 18px Roboto, Arial, sans-serif;
    overflow: hidden;
    height: 40px;
    cursor: pointer;
}

.custom-map-control-button:hover {
    background: rgb(235, 235, 235);
}


body {
    height: 100vh !important;
    background: #fafbff;
}

.floatingButtonWrap {
    display: block;
    position: fixed;
    bottom: 45px;
    right: 45px;
    z-index: 999999999;
}

.floatingButtonInner {
    position: relative;
}

.floatingButton {
    display: block;
    width: 60px;
    height: 60px;
    text-align: center;
    background: -webkit-linear-gradient(45deg, #8769a9, #507cb3);
    background: -o-linear-gradient(45deg, #8769a9, #507cb3);
    background: linear-gradient(45deg, #8769a9, #507cb3);
    color: #fff;
    line-height: 50px;
    position: absolute;
    border-radius: 50% 50%;
    bottom: 0px;
    right: 0px;
    border: 5px solid #b2bedc;
    /* opacity: 0.3; */
    opacity: 1;
    transition: all 0.4s;
}

.floatingButton .fa {
    font-size: 15px !important;
}

.floatingButton.open,
.floatingButton:hover,
.floatingButton:focus,
.floatingButton:active {
    opacity: 1;
    color: #fff;
}


.floatingButton .fa {
    transform: rotate(0deg);
    transition: all 0.4s;
}

.floatingButton.open .fa {
    transform: rotate(270deg);
}

.floatingMenu {
    position: absolute;
    bottom: 60px;
    right: 0px;
    /* width: 200px; */
    display: none;
}

.floatingMenu li {
    width: 100%;
    float: right;
    list-style: none;
    text-align: right;
    margin-bottom: 5px;
}

.floatingMenu li a {
    padding: 8px 15px;
    display: inline-block;
    background: #ccd7f5;
    color: #6077b0;
    border-radius: 5px;
    overflow: hidden;
    white-space: nowrap;
    transition: all 0.4s;
    /* -webkit-box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.22);
    box-shadow: 1px 3px 5px rgba(0, 0, 0, 0.22); */
    -webkit-box-shadow: 1px 3px 5px rgba(211, 224, 255, 0.5);
    box-shadow: 1px 3px 5px rgba(211, 224, 255, 0.5);
}

.floatingMenu li a:hover {
    margin-right: 10px;
    text-decoration: none;
}
</style>
<div class="container-fluid">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Dashboard')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 d-none">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v2</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
   <?php
        $user_role = \App\Models\User::findOrFail(Auth::user()->id);
   ?>

    @if($announcement->count() > 0)
    <h3>Announcements</h3>
    @endif
    <div class="row">
        @foreach ($announcement as $announcements)
        <div class="col-md-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <span class="info-box-icon"><i class="nav-icon fas fa-users"></i> Who: </span>
                        {{$announcements->who}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p>
                        <span class="info-box-icon"><i class="nav-icon fas fa-bullhorn"></i> What: </span>
                        {{$announcements->what}}
                    </p>
                    <p>
                        <span class="info-box-icon"><i class="far fa-map"></i> Where: </span>
                        {{$announcements->where}}
                    </p>
                    <p>
                        <span class="info-box-icon"><i class="far fa-calendar-alt"></i> When: </span>
                        {{$announcements->when}}
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        @endforeach
    </div>

    <!-- Map card -->
    <div class="card bg-gradient-primary">
        <div class="card-header border-0">
            <h3 class="card-title">
                <i class="fas fa-map-marker-alt mr-1"></i>
                Visitors
            </h3>
            <!-- card tools -->
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
            <!-- /.card-tools -->
        </div>
        <div class="card-body">
            <div id="map" style="height: 500px; width: 100%;"></div>
        </div>
        <!-- /.card-body-->
        <div class="card-footer bg-transparent d-none">
            <div class="row">
                <div class="col-4 text-center">
                    <div id="sparkline-1"></div>
                    <div class="text-white">Visitors</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                    <div id="sparkline-2"></div>
                    <div class="text-white">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                    <div id="sparkline-3"></div>
                    <div class="text-white">Sales</div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.row -->
</div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    {{-- <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
            cluster: '{{env('PUSHER_APP_CLUSTER')}}'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script> --}}

<script>

// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see the error "The Geolocation service
// failed.", it means you probably did not give permission for the browser to
// locate you.
var map, infoWindow;
const labels = "X";
//let markers = [];
let labelIndex = 0;

// setInterval(() => {
//     initMap();
// }, 5000);

function initMap() {
    var bounds = new google.maps.LatLngBounds();
    map = new google.maps.Map(document.getElementById('map'), {
        // center: {
        //     lat: -34.397,
        //     lng: 150.644
        // },
        //zoom: 12
    });
    infoWindow = new google.maps.InfoWindow;

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        setInterval(() => {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                $('#txtLatitude').val(position.coords.latitude);
                $('#txtLongitude').val(position.coords.longitude);
                bounds.extend(new google.maps.LatLng(position.coords.latitude,position.coords.longitude));

                infoWindow.setPosition(pos);
                //infoWindow.setContent('Location found.');
                //infoWindow.open(map);

                var marker = new google.maps.Marker({
                    map: map,
                    position: pos,
                    flat: false,
                    //animation: google.maps.Animation.BOUNCE,
                    //label: labels[labelIndex++ % labels.length],
                });

                setInterval(() => {
                    marker.setMap(map);
                }, 1999);
                setInterval(() => {
                    marker.setMap(null);
                }, 2000);
                map.setCenter(pos);
                marker.setMap(map);
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        }, 2000);

        google.maps.event.addListener(map, "bounds_changed", function() {
            // send the new bounds back to your server
                //console.log("map bounds{"+map.getBounds());
                //this.setZoom(map.getZoom()-1);

                // if (this.getZoom() > 15) {
                //     this.setZoom(15);
                // }
            });

        //center the map to the geometric center of all markers
        //map.setCenter(bounds.getCenter());
        //map.fitBounds(bounds);
        //remove one zoom level to ensure no marker is on the edge.
        map.setZoom(12);
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}
window.initMap = initMap;

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    var marker = new google.maps.Marker({
        map: map,
        position: pos,
        //animation: google.maps.Animation.BOUNCE,
        //label: labels[labelIndex++ % labels.length],
    });

    setInterval(() => {
        marker.setMap(map);
    }, 1999);
    setInterval(() => {
        marker.setMap(null);
    }, 2000);


    // infoWindow.setContent(browserHasGeolocation ?
    //     'Error: The Geolocation service failed.' :
    //     'Error: Your browser doesn\'t support geolocation.');
    //infoWindow.open(map);
}
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClxpzuEYmbt5qmjpkB348ouv2V-pL4TII&callback&libraries=visualization&callback=initMap">
</script>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var getData = e.target.result.split(':')[0];
            var getType = e.target.result.split(':')[1];
            var typeResult = getType.split('/')[0];
            if (typeResult === 'image') {
                $('#img_incident').attr('src', e.target.result);
            } else {}


        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    // var user = "{{ Auth::user()->name; }}";
    // var role = "{{ Auth::user()->role; }}";
    // setInterval(function(){
    //     toastr.error('Flood Incident ' + user + " " + role);
    // },2000);

    var role = "{{Auth::user()->role}}";
    if (role == 9){
         Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                
                // get service worker
                navigator.serviceWorker.ready.then((sw) =>{
                    
                    // subscribe
                    sw.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey:"BC5zel9JoqeOY2yVTJjDhiE1IisJTVHq-_p4rxC3zd60gQSqXzra_7_m7B12axwI42tZIUXYGXhIJ-t5MolKjNY"
                    }).then((subscription) => {

                        // subscription successful
                        fetch("/api/push-subscribe", {
                            method: "post",
                            body:JSON.stringify(subscription)
                        }).then( 
                            console.log(subscription)
                        );
                    });
                });
            }
        });
    }

    if (role == 10){
        navigator.serviceWorker.ready.then((sw) =>{
            // subscribe
            sw.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey:"BC5zel9JoqeOY2yVTJjDhiE1IisJTVHq-_p4rxC3zd60gQSqXzra_7_m7B12axwI42tZIUXYGXhIJ-t5MolKjNY"
            }).then((subscription) => {

                fetch("/api/push-subscribe-residents", {
                    method: "post",
                    body:{
                        data:JSON.stringify(subscription),
                        id:"{{Auth::user()->id}}"
                    }
                }).then( 
                    console.log(subscription)
                );
                // subscription successful
                $.get('{{ url('incidents/resident_notify') }}', {
                    data:JSON.stringify(subscription),
                    id: "{{Auth::user()->id}}"
                }, function(html) {
                    
                })
            });
        });
    }

    $('#frmIncident').submit(function (e) {
        $('#btnSubmit').css('pointer-events: none');
        $('#btnSubmit').addClass('d-none');
        $('#btnSpin').removeClass('d-none');
        $('#btnCancel').class('d-none');
    });
    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
    $('#img_incident').click(function(e) {
        $('#choose_image').trigger('click');
    });
    $('.floatingButton').click(function() {
        $('#modal_incident').modal('show');
    });

});
</script>
@endpush
