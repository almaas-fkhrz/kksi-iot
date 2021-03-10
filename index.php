<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
    html,
    body {
        margin: 0;
        padding: 0;
    }

    #map {
        height: 92vh;
    }
    </style>
    <title>Home</title>
    <!-- <link rel="stylesheet" href="leaflet/leaflet.css" /> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <!-- <script src="leaflet/leaflet.js"></script> -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
</head>

<body>
    <nav class="navbar navbar-dark bg-info" style="height:8vh;">
        <a class="navbar-brand" href="#">GPS Vehicle Tracker</a>
    </nav>
    <!-- <p id='name'></p> -->
    <div id="map"></div>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-database.js"></script>
<script>
// var firebaseConfig = {
//     apiKey: "AIzaSyC76-qBSghOJb01tzdh3xzaKKsoAgAwusg",
//     authDomain: "maps-28.firebaseapp.com",
//     databaseURL: "https://maps-28.firebaseio.com",
//     projectId: "maps-28",
//     storageBucket: "maps-28.appspot.com",
//     messagingSenderId: "673709651205",
//     appId: "1:673709651205:web:64543fa5c07accf7d4f36c",
//     measurementId: "G-T9QTN4TFGR"
// };

// firebase.initializeApp(firebaseConfig);
// firebase.analytics();

var firebaseConfig = {
    apiKey: "AIzaSyBDHNNnfEWfnzb5hvCATSiZaNDOLYGTFKw",
    authDomain: "bus-tracker-1194c.firebaseapp.com",
    databaseURL: "https://bus-tracker-1194c.firebaseio.com",
    projectId: "bus-tracker-1194c",
    storageBucket: "bus-tracker-1194c.appspot.com",
    messagingSenderId: "745876107344",
    appId: "1:745876107344:web:36426ffaf09af3d7c6a155",
    measurementId: "G-8RV37DEGY4"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();

var db, usersRef;

db = firebase.database();
usersRef = db.ref('bus1');

usersRef.on('value', dataBerhasil);

var lat, long;

var halteIcon = L.icon({
    iconUrl: 'leaflet/bus-stop.png',
    iconSize: [35, 35],
    iconAnchor: [22, 35],
    popupAnchor: [-4, -40]
    // shadowUrl: 'my-icon-shadow.png',
    // shadowSize: [68, 95],
    // shadowAnchor: [22, 94]
});

var busIcon = L.icon({
    iconUrl: 'leaflet/bus.png',
    iconSize: [28, 30],
    iconAnchor: [22, 24],
    popupAnchor: [-8, -30]
    // shadowUrl: 'my-icon-shadow.png',
    // shadowSize: [68, 95],
    // shadowAnchor: [22, 94]
});

var map = L.map('map');
var marker = L.marker([51.505, -0.09], {
    opacity: 0,
    icon: busIcon,
    zIndexOffset: 10000
}).addTo(map);
var bus2 = L.marker([-7.412526, 109.341132], {
    icon: busIcon
}).addTo(map);
bus2.bindPopup("Bus 2").openPopup();
var halte1 = L.marker([-7.398101, 109.351045], {
    icon: halteIcon
}).addTo(map);
halte1.bindPopup("Halte 1").openPopup();
var halte2 = L.marker([-7.403941, 109.347134], {
    icon: halteIcon
}).addTo(map);
halte2.bindPopup("Halte 2").openPopup();
var halte3 = L.marker([-7.409958, 109.342880], {
    icon: halteIcon
}).addTo(map);
halte3.bindPopup("Halte 3").openPopup();
// L.marker([lat, long]).addTo(map);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: '&copy; 2020 GVT Smega v1.0',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiYWxtYWFzIiwiYSI6ImNraTV6bnpnaTJwc28yc2x0MG44aHdieXEifQ.a7Djbjrlq_Mhm-0eRev1cg'
}).addTo(map);

function dataBerhasil(data) {
    // document.getElementById('name').innerHTML = data.val().name;
    // console.log(data.val().name);
    lat = data.val().latitude;
    long = data.val().longitude;
    console.log(data.val().latitude);
    console.log(data.val().longitude);
    map.setView([lat, long], 15);
    var newLatLng = new L.LatLng(lat, long);
    marker.setLatLng(newLatLng);
    marker.setOpacity(1);
    marker.bindPopup("Bus 1").openPopup();
}
</script>

</html>