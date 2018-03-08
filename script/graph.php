<style type="text/css">
        svg{
            display: block;
            width: 100%;
            align: center;
        }
        .link {stroke: rgba(0, 0, 0, .8); stroke-opacity: .4; stroke-width: 0.8px;} 
        div#info-node-link{
            margin: 2em;
        }
</style>

<svg width="960" height="600"></svg>

<script type="text/javascript">
    var colors = d3.scaleOrdinal(d3.schemeCategory10);
    var svg = d3.select("svg"),
        width = +svg.attr("width"),
        height = +svg.attr("height"),
        node,
        link;
    svg.append('defs').append('marker')
        .attrs({'id':'arrowhead',
            'viewBox':'-0 -5 10 10',
            'refX':17,
            'refY':0,
            'orient':'auto',
            'markerWidth':8,
            'markerHeight':8,
            'xoverflow':'visible'})
        .append('svg:path')
        .attr('d', 'M 0,-5 L 10 ,0 L 0,5')
        .attr('fill', 'rgba(0, 0, 0, .8)')
        .style('stroke','none');
    var simulation = d3.forceSimulation()
        .force("link", d3.forceLink().id(function (d) {return d.id;}).distance(200).strength(1))
        .force("charge", d3.forceManyBody())
        .force("center", d3.forceCenter(width / 2, height / 2));
    <?php
        $COMMAND = "red generateDot('a \ 'b . { 'A } | 'c \ 'd .  { 'B}  , ('A =d= 'x \ 'y . { 'A} , 'B =d= 'w \ 'w . 't \ 't . { 'B} )) .";
        //$COMMAND = "red generateDot(['d_0, 'd_1, 'u_0_L, 'u_0_R, 'u_1_L, 'u_1_R]{'P_1} | ({'F_1} | ({'P_0} | {'F_0}))  , ('F_0 =d= tau \ 'u_0_R . tau \ 'd_0 . {'F_0} + 'u_0_L \ tau . 'd_0 \ tau . {'F_0}, 'F_1 =d= tau \ 'u_1_R . tau \ 'd_1 . {'F_1} + 'u_1_L \ tau . 'd_1 \ tau . {'F_1}, 'P_0 =d= tau \ 'think_0 . {'P_0} + 'u_0_R \ 'u_1_L . {'eat_0}, 'P_1 =d= tau \ 'think_1 . {'P_1} + 'u_1_R \ 'u_0_L . {'eat_1}, 'eat_0 =d= tau \ 'eat_0 . {'release_0}, 'eat_1 =d= tau \ 'eat_1 . {'release_1}, 'release_0 =d= 'd_0 \ 'd_1 . {'P_0}, 'release_1 =d= 'd_1 \ 'd_0 . {'P_1})) .";
        $DIR_MAUDE = "/usr/bin/maude";
        $DIR_FILE_MAUDE = "/home/glauberca/Documentos/Silver/semantics.maude";
        $MODF = "-no-banner";
        require_once ("maude-silver-run.php");
        $file_name = createFile($COMMAND, $DIR_MAUDE, $DIR_FILE_MAUDE, $MODF);
        echo "d3.json(\"$file_name\", function (error, graph) {
            if (error) throw error;
            update(graph.links, graph.nodes);
        });";
     ?>
    function update(links, nodes) {
        link = svg.selectAll(".link")
            .data(links)
            .enter()
            .append("polyline")
            //.append("line")
            .attr("class", "link")
            .style("fill","none")
            .attr('marker-end','url(#arrowhead)')
            
        link.append("title")
            .text(function (d) {return d.type;});
        edgepaths = svg.selectAll(".edgepath")
            .data(links)
            .enter()
            .append('path')
            .attrs({
                'class': 'edgepath',
                'fill-opacity': 0,
                'stroke-opacity': 0,
                'id': function (d, i) {return 'edgepath' + i}
            })
            .style("pointer-events", "none");
        edgelabels = svg.selectAll(".edgelabel")
            .data(links)
            .enter()
            .append('text')
            .style("pointer-events", "none")
            .attr("dx",".90em")
            .attr("dy",".10em")
            .attrs({
                'class': 'edgelabel',
                'id': function (d, i) {return 'edgelabel' + i},
                'font-size': 10,
                'fill': 'rgba(175, 175, 174, 0.9)'
                
                
            });
        edgelabels.append('textPath')
            .attr('xlink:href', function (d, i) {return '#edgepath' + i})
            .style("text-anchor", "middle")
            .style("pointer-events", "none")
            .attr("startOffset", "50%")
            
            .text(function (d) {return d.type});
        node = svg.selectAll(".node")
            .data(nodes)
            .enter()
            .append("g")
            .attr("class", "node")
            .call(d3.drag()
                    .on("start", dragstarted)
                    .on("drag", dragged)
                    .on("end", dragended)
            );
        node.append("circle")
            .attr("r", 8)
            .style("fill", function (d, i) {return colors(i);})
        node.append("title")
            .text(function (d) {return d.id;});
        node.append("text")
            .attr("dy", -3)
            //.text(function (d) {return d.name+":"+d.label;});   //Show node label
        simulation
            .nodes(nodes)
            .on("tick", ticked);
        simulation.force("link")
            .links(links);
            allLinks = links;
    }
    function ticked() {
        
        link
            
             
            .attr("points", function(d){
                var bothLink = false;
                var pX = new Array();
                var pY = new Array();
                pX[0] = d.source.x;
                pY[0] = d.source.y;
                pX[17] = d.target.x;
                pY[17] = d.target.y;
                if(d.source.id == d.target.id){
                    pX[1] = d.source.x + 2.5; pY[1] = d.source.y - 0  ;
                    pX[2] = d.source.x + 7.5; pY[2] = d.source.y - 2.5 ;
                    pX[3] = d.source.x + 10; pY[3] = d.source.y - 5 ;
                    pX[4] = d.source.x + 12.5; pY[4] = d.source.y - 10 ;
                    pX[5] = d.source.x + 12.5; pY[5] = d.source.y - 15 ;
                    pX[6] = d.source.x + 10; pY[6] = d.source.y - 20 ;
                    pX[7] = d.source.x + 7.5; pY[7] = d.source.y - 22.5 ;
                    pX[8] = d.source.x + 2.5; pY[8] = d.source.y -  25;
                    pX[9] = d.source.x - 2.5; pY[9] = d.source.y - 25;
                    pX[10] = d.source.x -7.5; pY[10] = d.source.y -22.5 ;
                    pX[11] = d.source.x -10; pY[11] = d.source.y -20 ;
                    pX[12] = d.source.x -12.5; pY[12] = d.source.y -15 ;
                    pX[13] = d.source.x -12.5; pY[13] = d.source.y -10 ;
                    pX[14] = d.source.x -10; pY[14] = d.source.y -5 ;
                    pX[15] = d.source.x -10; pY[15] = d.source.y -5 ;
                    pX[16] = d.source.x -10; pY[16] = d.source.y -5  ;
                    
                    
                }else{
                    for(var i in allLinks){
                        if(allLinks[i].source.id == d.target.id){
                            if(allLinks[i].target.id == d.source.id){
                                if(d.source.id < d.target.id){
                                    bothLink = true;
                                    pY[17] = d.target.y-4;
                                    pX[17] = d.target.x-4;
                                }
                                
                            }
                        }
                        
                    }
                    for(var z=1; z<17; z++ ){
                        if(bothLink==false){
                            pY[z] = d.source.y;
                            pX[z] = d.source.x;
                        }else {
                            pY[z] = d.source.y-4;
                            pX[z] = d.source.x-4;
                        }
                        
                    }
                }
                var result = pX[0].toString() + "," + pY[0].toString() + ", " + 
                             pX[1].toString() + "," + pY[1].toString() + ", " +
                             pX[2].toString() + "," + pY[2].toString() + ", " +
                             pX[3].toString() + "," + pY[3].toString() + ", " +
                             pX[4].toString() + "," + pY[4].toString() + ", " +
                             pX[5].toString() + "," + pY[5].toString() + ", " +
                             pX[6].toString() + "," + pY[6].toString() + ", " +
                             pX[7].toString() + "," + pY[7].toString() + ", " +
                             pX[8].toString() + "," + pY[8].toString() + ", " +
                             pX[9].toString() + "," + pY[9].toString() + ", " +
                             pX[10].toString() + "," + pY[10].toString() + ", " +
                             pX[11].toString() + "," + pY[11].toString() + ", " +
                             pX[12].toString() + "," + pY[12].toString() + ", " +
                             pX[13].toString() + "," + pY[13].toString() + ", " +
                             pX[14].toString() + "," + pY[14].toString() + ", " +
                             pX[15].toString() + "," + pY[15].toString() + ", " +
                             pX[16].toString() + "," + pY[16].toString() + ", " +
                             pX[17].toString() + "," + pY[17].toString();
                return result;
            });
            
            
        node
            .attr("transform", function (d) {return "translate(" + d.x + ", " + d.y + ")";});
        edgepaths.attr('d', function (d) {
            return 'M ' + d.source.x + ' ' + d.source.y + ' L ' + d.target.x + ' ' + d.target.y;
        });
        edgelabels.attr('transform', function (d) {
            var bbox = this.getBBox();
            
            rx = bbox.x+1 + bbox.width / 2;
            ry = bbox.y+1 + bbox.height / 2;
                
            for(var i in allLinks){
                    if(allLinks[i].source.id == d.target.id){
                        if(allLinks[i].target.id == d.source.id){
                            if(d.source.id < d.target.id){
                                rx = bbox.x-3 + bbox.width / 2;
                                ry = bbox.y-3 + bbox.height / 2;
                            }
                                    
                        }
                    }
                }  
                
                if (d.target.x < d.source.x) {
                    return 'rotate(180 ' + rx + ' ' + ry + ')';
                }else{
                    return 'rotate(0)';
                }
                
        });
    }
      
    
    function dragstarted(d) {
        if (!d3.event.active) simulation.alphaTarget(0.3).restart()
        d.fx = d.x;
        d.fy = d.y;
        $("tbody#target td").remove();
        $("span#node").text(d.id);
        for(var i in allLinks){
            if(allLinks[i].source.id == d.id){
                if(allLinks[i].target.id == d.id){
                    $("tbody#target").append("<tr><td><small>" + "self" + "</small></td>" + "<td><small>" + allLinks[i].type + "</small></td></tr>");
                }else{
                    $("tbody#target").append("<tr><td><small>" + allLinks[i].target.id + "</small></td>" + "<td><small>" + allLinks[i].type + "</small></td></tr>");                    
                }
                
            }  
        }
    }
    function dragged(d) {
        d.fx = d3.event.x;
        d.fy = d3.event.y;
    }
    function dragended(d) {
        if (!d3.event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
    }
</script>