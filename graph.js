var chartCanvasIds = ['assetchart', 'aoassetchart'];

function fetchData(type, canvasId) {
    var xhr = new XMLHttpRequest();
    var url = 'chartfunction.php';
    var params = null;

    if (type === 'aoassetchart') {
        params = 'selectedOfficeId=' + canvasId;
    }

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            var data = JSON.parse(xhr.responseText);
            updateChart(canvasId, data);
        }
    };
    xhr.onerror = function() {
        console.error('Failed to fetch data');
    };

    xhr.send(params);
}


function updateCharts(selectedOfficeId) {
    if (selectedOfficeId) {
        fetchData(selectedOfficeId); 
    } else {
        fetchData('assets', 'assetchart');
    }
}

function updateChart(canvasId, data) {
    var labels = data.labels;
    var values = data.values;

    var ctx = document.getElementById(canvasId).getContext('2d');
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    if (window[canvasId] instanceof Chart) {
        window[canvasId].data.labels = labels;
        window[canvasId].data.datasets[0].data = values;
        window[canvasId].update();
    } else {
        window[canvasId] = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: (canvasId === 'assetchart') ? 'ASSET LDN' : 'ASSET COUNT',
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
}

updateCharts();
setInterval(updateCharts, 18000);
