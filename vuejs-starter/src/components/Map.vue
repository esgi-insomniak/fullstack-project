<script setup>
import Map from "../helpers/map/map.js";
import L from 'leaflet'
import { onMounted } from "vue";

const props = defineProps({
  id: {
    type: String,
    required: false,
    default: 'mapContainer',
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
  defaultPoint: {
    type: Object,
    required: false,
    default: () => {
      return {
        name: 'Paris',
        coordinates: [48.8588897,2.320041],
      };
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
const emit = defineEmits(['onMapSuccess', 'onMapError', 'onMapClick']);

const loadMap = (jawg) => {
  const map = new L.map(props.id)
      .setView([0, 0], props.zoom)
      .setMaxBounds([
        [-90, -180],
        [90, 180],
      ])
  ;

  // display pointsToDisplay
  props.pointsToDisplay.forEach(point => {
    const marker = L.marker(point.coordinates, {
      icon: props.iconToDisplay,
      uniqueId: point.uniqueId ?? null,
    })
        .addTo(map);

    if(point.name)
      marker.bindPopup(point.name);
    if(point.onClick)
      marker.on('click', point.onClick);
  });

  if (props.defaultPoint.coordinates && props.defaultPoint.coordinates.length === 2 && props.defaultPoint.name) {
    map.setView(props.defaultPoint.coordinates, props.zoom);
    L.marker(props.defaultPoint.coordinates).addTo(map).bindPopup(props.defaultPoint.name);
  }

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
      transition: {
        type: 'hybrid'
      },
      placeholder: 'Cherchez une ville',
      size: 5,
      sources: 'wof',
      L: L,
      onFeatures: (success) => emit('onMapSuccess', success),
      onError: (error) => emit('onMapError', error),
      onClick: (feature) => emit('onMapClick', feature),
    });
    map.addControl(control);
  }

}

onMounted(async () => {
  loadMap(await Map.getInstance());
});
</script>

<template>
  <div class="rounded shadow-lg" :id="id" :style="{ width: width, height: height }"></div>
</template>

<style scoped>

</style>