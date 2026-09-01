/**
 * JS para renderizar GeoJSON en mapa interactivo (Home)
 */
document.addEventListener('DOMContentLoaded', () => {
    const mapContainer = document.getElementById('mapa-negocios');
    if (!mapContainer || typeof L === 'undefined') return;

    // Coordenadas Yaguará por defecto
    const lat = 2.6633;
    const lng = -75.5225;
    const zoom = 15;

    const map = L.map('mapa-negocios').setView([lat, lng], zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    const baseUrl = window.location.origin + window.location.pathname.replace('/index.php', '').replace(/\/$/, '') + '/';

    // Cargar negocios GeoJSON
    fetch(`${baseUrl}index.php?url=api/negocios`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        // Icono custom SVG
        const createCustomIcon = (color) => {
            const svgIcon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="24" height="32"><path fill="${color}" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>`;
            return L.divIcon({
                html: svgIcon,
                className: 'custom-leaflet-marker',
                iconSize: [24, 32],
                iconAnchor: [12, 32],
                popupAnchor: [0, -32]
            });
        };

        L.geoJSON(data, {
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, { icon: createCustomIcon(feature.properties.color) });
            },
            onEachFeature: function(feature, layer) {
                const p = feature.properties;
                const popupContent = `
                    <div style="min-width:200px;text-align:center;">
                        ${p.logo ? `<img src="${baseUrl}${p.logo}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;margin-bottom:10px;">` : ''}
                        <div style="font-size:0.75rem;color:${p.color};font-weight:bold;margin-bottom:3px;text-transform:uppercase;">
                            <i class="${p.icono}"></i> ${p.categoria}
                        </div>
                        <h6 style="margin:0 0 5px;font-weight:bold;color:#0f172a;">${p.nombre}</h6>
                        <p style="margin:0 0 10px;font-size:0.8rem;color:#64748b;">${p.direccion}</p>
                        <a href="${p.url}" style="display:inline-block;padding:5px 15px;background:#059669;color:white;text-decoration:none;border-radius:20px;font-size:0.8rem;font-weight:600;">Ver Negocio</a>
                    </div>
                `;
                layer.bindPopup(popupContent);
            }
        }).addTo(map);
    })
    .catch(error => console.error('Error cargando mapa:', error));
});
