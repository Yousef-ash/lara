import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});
const device_id = document.getElementById('device-id').value;


window.Echo.channel('sensor.' + device_id).listen('SensorDataUpdated', (e) => {

    const tableBody = document.querySelector('#sensor-table tbody');
    let time = e.sensor.created_at;
console.log(e.sensor.created_at)
    const timestampDate = new Date(time);

    const day = timestampDate.getUTCDate();
    const month = (timestampDate.getMonth() + 1);
    const year = timestampDate.getFullYear();
    const hours = timestampDate.getHours() % 12;
    const minutes = timestampDate.getMinutes();
    const seconds = timestampDate.getSeconds();
    const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

let result;
let uv;
if (e.sensor.dust <= 1000) {
    result = 'Clean';
} else if (e.sensor.dust > 1000 && e.sensor.dust < 10000) {
    result = 'Good';
} else if (e.sensor.dust > 10000 && e.sensor.dust < 20000) {
    result = 'Acceptable';
} else if (e.sensor.dust > 20000 && e.sensor.dust < 50000) {
    result = 'Heavy';
} else if (e.sensor.dust > 50000) {
    result = 'Hazard';
} else {
    result = 'Unknown';
}

if (e.sensor.uv <= 4) {
    uv = 'Normal';
} else {
    uv = 'High';
}
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${e.device_name}</td>
        <td>${e.sensor.temperature}</td>
        <td>${e.sensor.uv}</td>
        <td>${uv}</td>
        <td>${e.sensor.humidity}</td>
        <td>${e.sensor.co}</td>
        <td>${e.sensor.co_two}</td>
        <td>${e.sensor.dust}</td>
        <td>${result}</td>
        <td>${formattedDate}</td>
    `;

    // Insert the new row at the top of the table
    tableBody.insertBefore(newRow, tableBody.firstChild);

});
