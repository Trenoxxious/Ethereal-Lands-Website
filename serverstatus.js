const SERVER_IP = '162.211.87.91';
const SERVER_PORT = 8080;
const CHECK_INTERVAL = 15000;

function updateServerStatus() {
    const statusText = document.getElementById('status-text');
    const serverName = document.getElementById('server-name');
    const responseTime = document.getElementById('response-time');

    const startTime = Date.now();

    fetch(`http://${SERVER_IP}:${SERVER_PORT}/status`)
        .then(response => response.json())
        .then(data => {
            const endTime = Date.now();
            const pingTime = endTime - startTime;

            statusText.textContent = 'Online';
            serverName.style.background = '#06bf23';
            responseTime.textContent = `${pingTime / 2}ms`;
        })
        .catch(error => {
            console.error('Error:', error);
            statusText.textContent = 'Offline';
            serverName.style.background = '#bf0606';
            responseTime.textContent = 'N/A';
        });
}

updateServerStatus();
setInterval(updateServerStatus, CHECK_INTERVAL);