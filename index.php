<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FDN Analytics</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">FDN Analytics</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/">Daily</a>
                    </li>

                    <li><a href="weekly.php">Weekly</a>

                    <li><a href="monthly.php">Monthly</a>
                    </li>
                    
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" title=""><div id="embed-api-auth-container"></a></div></li>
                </ul>
            </div>
            <!--/.navbar-collapse -->
        </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
   
    <?php 
        $yesterday  = date('l j-F', mktime(0, 0, 0, date("m") , date("d")-1, date("Y")));
        $xxx  = date('l j-F', mktime(0, 0, 0, date("m")  , date("d")-7, date("Y")));
    ?>


    <div class="container main">

        <!--<div class="row">
            <div class="btn-group" role="group" aria-label="...">
              <button type="button" class="btn btn-default">Left</button>
              <button type="button" class="btn btn-default">Middle</button>
              <button type="button" class="btn btn-default">Right</button>
            </div>
        </div>-->
        <div class="row">
            <div id="view-selector-container"></div>
        </div>

        <div class="row">
            <hr>
            <h3>Weekly ( <?php echo ($xxx . ' s/d ' . $yesterday); ?> )</h3>
            <hr>
        </div>

        <div class="row">
            <div class="col-md-6">  
                <h3>Pageviews</h3>
                <small>Counts the total number of pageviews.</small>
                <div id="chart-pageviews-container"></div>
            </div>
            <div class="col-md-6">
                <h3>Sessions</h3>
                <small>Counts the total number of sessions.</small>
                <div id="chart-container"></div>
            </div>
            <div class="col-md-6">
                <h3>Bounce Rate</h3>
                <small>The percentage of single-page session (i.e., session in which the person left your property from the first page)</small>
                <div id="chart-bounce-container"></div>
            </div>
            <div class="col-md-6">
                <h3>Hits</h3>
                <small>otal number of hits sent to Google Analytics. This metric sums all hit types (e.g. pageview, event, timing, etc.).</small>
                <div id="chart-hits-container"></div>
            </div>
        </div>

        <hr>

        <br>


        <footer>
            <p>&copy; Female Daily Network 2014</p>
        </footer>
    </div>
    <!-- /container -->

    <script>
    (function(w, d, s, g, js, fs) {
        g = w.gapi || (w.gapi = {});
        g.analytics = {
            q: [],
            ready: function(f) {
                this.q.push(f);
            }
        };
        js = d.createElement(s);
        fs = d.getElementsByTagName(s)[0];
        js.src = 'https://apis.google.com/js/platform.js';
        fs.parentNode.insertBefore(js, fs);
        js.onload = function() {
            g.load('analytics');
        };
    }(window, document, 'script'));
    </script>

    <script>
    gapi.analytics.ready(function() {

        /**
         * Authorize the user immediately if the user has already granted access.
         * If no access has been created, render an authorize button inside the
         * element with the ID "embed-api-auth-container".
         */
        gapi.analytics.auth.authorize({
            container: 'embed-api-auth-container',
            clientid: '1061517742113-vk09kc7adlb4q6b134d726bdvg2ekuj8.apps.googleusercontent.com',
        });


        /**
         * Create a new ViewSelector instance to be rendered inside of an
         * element with the id "view-selector-container".
         */
        var viewSelector = new gapi.analytics.ViewSelector({
            container: 'view-selector-container'
        });

        // Render the view selector to the page.
        viewSelector.execute();


        /**
         * Create a new DataChart instance with the given query parameters
         * and Google chart options. It will be rendered inside an element
         * with the id "chart-container".
         */
        var dataChart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:visits',
                dimensions: 'ga:day',
                'start-date': '7daysAgo',
                'end-date': 'yesterday'
            },
            chart: {
                container: 'chart-container',
                type: 'COLUMN',
                options: {
                    width: '100%'
                }
            }
        });

        /**
         * Create a new DataChart instance for pageviews over the 7 days prior
         * to the past 7 days.
         * It will be rendered inside an element with the id "chart-2-container".
         */
        var dataChartPageviews = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:pageviews',
                dimensions: 'ga:day',
                'start-date': '7daysAgo',
                'end-date': 'yesterday'
            },
            chart: {
                container: 'chart-pageviews-container',
                type: 'COLUMN',
                options: {
                    width: '100%'
                }
            }
        });

        /**
         * Create a new DataChart instance for pageviews over the past 7 days.
         * It will be rendered inside an element with the id "chart-1-container".
         */
        var dataChart1 = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:bounceRate',
                dimensions: 'ga:day',
                'start-date': '7daysAgo',
                'end-date': 'yesterday'
            },
            chart: {
                container: 'chart-bounce-container',
                type: 'COLUMN',
                options: {
                    width: '100%'
                }
            }
        });


        /**
         * Create a new DataChart instance for pageviews over the 7 days prior
         * to the past 7 days.
         * It will be rendered inside an element with the id "chart-2-container".
         */
        var dataChart2 = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:hits',
                dimensions: 'ga:day',
                'start-date': '7daysAgo',
                'end-date': 'yesterday'
            },
            chart: {
                container: 'chart-hits-container',
                type: 'COLUMN',
                options: {
                    width: '100%'
                }
            }
        });


        /**
         * Render both dataCharts on the page whenever a new view is selected.
         */
        viewSelector.on('change', function(ids) {
            dataChart.set({
                query: {
                    ids: ids
                }
            }).execute();

            dataChartPageviews.set({
                query: {
                    ids: ids
                }
            }).execute();

            dataChart1.set({
                query: {
                    ids: ids
                }
            }).execute();

            dataChart2.set({
                query: {
                    ids: ids
                }
            }).execute();
        });

    });
    </script>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
