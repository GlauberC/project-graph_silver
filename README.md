php-forced-direct-maude-graph

This repository create a forced direct graph from maude file called SiLVer# project-graph_silver


Version history:
 v3.x

    v 3.11  
        It was created create_graph.php  
    v 3.1
        It was created index.php and explore.php  
        The temp.php was moved to explore.php  
        The graph script was moved to script/graph.php  
        It was applied bootstrap on nav that was found on link: https://bootsnipp.com/snippets/featured/inline-navbar-search  
        It was created a text box in index.html and it was possible send strings to explore.php, but It doesn't have function yet.  
        The width of graph is now 100% of screen.   

v2.x  

    v 2.1
        Fixed issue with the created nodes that contains ];
        Fixed issue with repeat targets in lists;
        Now will show the labels of links;
        it was turned the lists in tables;
        it was aplied bootstrap to improve reading of tables;
    v 2.0
        it was create obj as stdClass to remove warnings
        The graph works again
    V 1.19b
        Added Permission 0444 on tmpfname
        Added relative path on createFile function.  "return "./output/" . basename($tmpfname);"
    V 0.19
        Link from maude-silver-run to temp.php
    V 0.11
        The size of edgelabels has been increased
        The Edgelabel does not stay in upside down