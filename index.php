<!DOCTYPE HTML>
<html lang="en">
<head>
    <script src="http://d3js.org/d3.v4.min.js" type="text/javascript"></script>
    <script src="http://d3js.org/d3-selection-multi.v1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="script/graph.js"></script>

</head>
<!--BOOTSTRAP NAV: https://bootsnipp.com/snippets/featured/inline-navbar-search -->


<body>
    <div class="container-full">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#silver-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">SiLVer Graph</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="silver-navbar-collapse">
                    <ul class="nav navbar-nav nav-tabs">
                        <li class="active tab1"><a data-toggle="tab" href="#tab_edit">Edit</a></li>
                        
                        <li id="explore"><a id="id_tab2" data-toggle="tab" href="#tab_explore">Explore</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    
        <div class="container tab-content">
            <div id="tab_edit" class="tab-pane fade in active">
                <form>
                    <div class="form-group">
                        <label for="graph">New Graph:</label>
                        <textarea class="form-control" rows="5" name="graph">red generateDot('a \ 'b . { 'A } | 'c \ 'd .  { 'B}  , ('A =d= 'x \ 'y . { 'A} , 'B =d= 'w \ 'w . 't \ 't . { 'B} )) .</textarea>
                        <input id="submitHide" type="button"  value="go" onclick='showGraph();'>
                    </div>
                </form>
            </div>
            <div id="tab_explore" class="tab-pane fade">
                <div id="graph_txt">
                <!-- This is the text that will be updated -->
                    Original Text
            </div>
        </div>
    </div>

</body>


</html>