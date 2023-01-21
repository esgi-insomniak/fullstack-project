<!-- <script setup>
import L from 'leaflet'
import { onMounted } from 'vue'

const accessToken = import.meta.env.VITE_API_JAWG_ACCESS_TOKEN
const bmwShops = [
    {
        id: 1,
        name: 'BMW Shop 1',
        address: '123 Main St',
        latitude: 37.7749,
        longitude: -122.4194
    },
    {
        id: 2,
        name: 'BMW Shop 2',
        address: '456 Market St',
        latitude: 37.7902,
        longitude: -122.4018
    }
]
onMounted(() => {
    // Create the map and set the view to the first BMW shop
    map = L.map('mapContainer').setView([bmwShops[0].latitude, bmwShops[0].longitude], 13)

    // Add the Jawg Maps tile layer to the map
    L.tileLayer(`https://{s}.tile.jawg.io/{style}/{z}/{x}/{y}{r}.png?access-token=${accessToken}`, {
        style: 'streets',
        attribution: '<a href="https://www.jawg.io" target="_blank">&copy; Jawg</a>',
        subdomains: 'abcd',
        minZoom: 0,
        maxZoom: 22,
        ext: 'jpg'
    }).addTo(map)

    // Add a marker for each BMW shop
    bmwShops.forEach(shop => {
        L.marker([shop.latitude, shop.longitude]).addTo(map)
    })
})

</script>

<template>
    <div class="w-full h-screen overflow-auto">
        <div ref="mapContainer" class="w-full h-full" />
    </div>
</template>
 -->

<script setup>
import JawgJSLoader from "@jawg/js-loader";
import L from 'leaflet'
import "leaflet/dist/leaflet.css";

const loader = new JawgJSLoader({ accessToken: 'rFPvpCTSLFoCgow6L3gmxotGfuCGOdg4IJUasbdb7JsGs6pgek324aK6hnAZx2kJ' });

loader.loadJawgPlaces().then((jawg) => {
  const map = new L.map('mapContainer').setView([0, 0], 2);
  map.addLayer(new L.TileLayer(
      'https://tile.jawg.io/jawg-sunny/{z}/{x}/{y}.png?access-token=rFPvpCTSLFoCgow6L3gmxotGfuCGOdg4IJUasbdb7JsGs6pgek324aK6hnAZx2kJ',
      {
        attribution: '<a href="http://jawg.io" title="Tiles Courtesy of Jawg Maps" target="_blank" class="jawg-attrib">&copy; <b>Jawg</b>Maps</a> | <a href="https://www.openstreetmap.org/copyright" title="OpenStreetMap is open data licensed under ODbL" target="_blank" class="osm-attrib">&copy; OSM contributors</a>',
        maxZoom: 22,
      }
  ));
  console.log(map)
  const control = new jawg.Leaflet({
    searchOnTyping: true,
    adminArea: {
      fillColor: 'rgba(172,59,246, 0.1)',
      outlineColor: 'rgb(172,59,246)',
      show: true,
    },
    sources: 'wof',
    L: L,
  });
  /*
  L.TileLayer(
    `https://tile.jawg.io/jawg-sunny/{z}/{x}/{y}.png?access-token=rFPvpCTSLFoCgow6L3gmxotGfuCGOdg4IJUasbdb7JsGs6pgek324aK6hnAZx2kJ`,
      {
        attribution: '<a href="http://jawg.io" title="Tiles Courtesy of Jawg Maps" target="_blank" class="jawg-attrib">&copy; <b>Jawg</b>Maps</a> | <a href="https://www.openstreetmap.org/copyright" title="OpenStreetMap is open data licensed under ODbL" target="_blank" class="osm-attrib">&copy; OSM contributors</a>',
        maxZoom: 22
      }
  ).addTo(map)*/
  map.addControl(control);
});
</script>
<template>
  <div id="mapContainer" class="mx-auto" style="aspect-ratio: 16/9; width: 800px" />
</template>