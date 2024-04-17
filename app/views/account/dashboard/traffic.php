    <div id="chartContainer" style="height: 100%; width: 100%; margin: 0px auto;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="<?=BASEURL?>/js/ajax-jquery-3.4.1/jquery.min.js"></script>

    <script>
        // window.onload = function () {
            var dps = [];
            var dps2 = [];
            var dataLength = 60;
            var updateInterval = 2000;
            var xVal = 0; 
            var yVal = 0; 
            var chart = new CanvasJS.Chart("chartContainer", {
                data: [
                    {
                        type: "spline",
                        name: "tx",
                        yValueFormatString: "#,### Kbps",
                        dataPoints: dps
                    },
                    {
                        type: "spline",
                        name: "rx",
                        yValueFormatString: "#,### Kbps",
                        dataPoints: dps2 
                    },
                ],
                toolTip: {
                    shared: true
                },
            });

            var updateChart = function (count) {
                $.getJSON("<?=BASEURL?>/dashboard_tx_rx?data=json&address=<?=Filter::request('','address')?>", function (data) {

                    var download = data.download/1000
                    var upload = data.upload/1000
                    console.log(download)
                    console.log(upload)
                    yVal = upload
                    yVal2 = download

                    count = count || 1;

                    for (var j = 0; j < count; j++) {
                        dps.push({
                            x: xVal,
                            y: yVal
                        });
                        dps2.push({
                            x: xVal,
                            y: yVal2
                        });
                        xVal++;
                    }

                    //jika datapoints telah melewati datalength
                    if (dps.length > dataLength) {
                        dps.shift();
                        dps2.shift();
                    }

                })
                chart.render();
            };

            updateChart(dataLength);

            setInterval(function () {
                updateChart()
            }, updateInterval);
        // }

    </script>