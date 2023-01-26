<script setup>
import JawgJSLoader from "@jawg/js-loader";
import L from 'leaflet'

const props = defineProps({
  id: {
    type: String,
    required: false,
    default: 'mapContainer',
  },
  coordinates: {
    type: Array,
    required: false,
    default: () => [48.8588897,2.320041],
  },
  zoom: {
    type: Number,
    required: false,
    default: 2,
  },
  search: {
    type: Boolean,
    required: false,
    default: true,
  },
  width: {
    type: String,
    required: false,
    default: '800px',
  },
  height: {
    type: String,
    required: false,
    default: '600px',
  },
  style: {
    type: String,
    required: false,
    default: 'streets',
    validator(value) {
      return ['streets', 'dark', 'light', 'terrain', 'sunny'].includes(value);
    }
  },
  click: {
    type: Function,
    required: false,
    default: () => {},
  },
  onSuccess: {
    type: Function,
    required: false,
    default: () => {},
  },
  onError: {
    type: Function,
    required: false,
    default: () => {
      console.error('Error while loading the map');
    },
  },
  pointsToDisplay: {
    type: Array,
    required: false,
    default: () => [],
  },
  iconToDisplay: {
    type: Object,
    required: false,
    default: () => new L.icon({
      iconUrl: '',
      iconSize: [25, 41],
      iconAnchor: [13, 41],
      popupAnchor: [0, -41]
    }),
  },
});


const token = import.meta.env.VITE_JAWGS_API_KEY;
const loader = new JawgJSLoader({ accessToken: token });

loader.loadJawgPlaces().then((jawg) => {
  const map = new L.map('mapContainer').setView(props.coordinates, props.zoom);

  // display pointsToDisplay
  props.pointsToDisplay.forEach(point => {
    L.marker(point.coordinates, {icon: props.iconToDisplay}).addTo(map).bindPopup(point.name);
  });

  map.addLayer(new L.TileLayer(
      `https://tile.jawg.io/jawg-${props.style}/{z}/{x}/{y}.png?access-token=${token}`,
      {
        attribution: '<a href="http://jawg.io" title="Tiles Courtesy of Jawg Maps" target="_blank" class="jawg-attrib">&copy; <b>Jawg</b>Maps</a> | <a href="https://www.openstreetmap.org/copyright" title="OpenStreetMap is open data licensed under ODbL" target="_blank" class="osm-attrib">&copy; OSM contributors</a>',
        maxZoom: 22,
        scale: 2,
        tileSize: 256,
      }
  ));

  // Si on veut la search bar
  if(props.search) {
    const control = new jawg.Leaflet({
      searchOnTyping: true,
      adminArea: {
        fillColor: 'rgba(172,59,246, 0.1)',
        outlineColor: 'rgb(172,59,246)',
        show: true,
      },
      size: 5,
      sources: 'wof',
      L: L,
      onFeatures: props.onSuccess,
      onError: props.onError,
      onClick: props.click,
    });
    map.addControl(control);
  }
});

</script>

<template>
  <div
    :id="id"
    :style="{ width: width, height: height }"
  ></div>
</template>

<style scoped>

</style>