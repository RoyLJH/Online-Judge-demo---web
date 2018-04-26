/**
 * Created by 卢嘉昊 on 2017/11/26.
 */
var drawArea = d3.select("body").select("div").select("table").select("tr#draw");
var contest = [0,0,300,440,
                0,0,420,0,
                0,370,440,130,
                0,0,0,0,
                140,0,0,290,
                370,370,0,0,
                0,0,0,0,
                440,340,330,0,
                0,0,0,0,
                0,240,0,0,
                400,0,370,0,
                0,0,0,0];
var month = ["January","February","March","April","May","June",
            "July","August","September","October","November","December"];
var progress = [380,160,430,30,320,300,20,420,140,160,350,0];  //progress = 100*contest + 10*problems
var contestNum = [2 ,1, 2,0, 2, 2,0, 3, 0,1, 2,0];
var problemNum = [18,6,23,3,12,10,2,12,14,6,15,0];


function generateA(solved,trying,all) {
    var width = document.getElementById("A").clientWidth;
    var height = document.getElementById("A").clientHeight;
    var unsolved = all-solved-trying;
    var solve = [solved,trying,unsolved];

    var svg = drawArea.select("td#A")
        .append("svg")
        .attr("width", width)
        .attr("height", height)
        ;
    var pie = d3.layout.pie().sort(null);   //定义饼图的布局
    var piedata = pie(solve); //将数据传给pie,就可以得到绘图的数据
    var outerRadius = 120; //外半径
    var innerRadius = 0; //内半径，为0则中间没有空白
    var sum=0;

    var arc = d3.svg.arc() //弧生成器
        .innerRadius(innerRadius) //设置内半径
        .outerRadius(outerRadius); //设置外半径

    var arcs = svg.selectAll("g")       //先添加五个分组元素，用来存放一段弧的相关元素
        .data(piedata)
        .sort(d3.ascending)
        .enter()
        .append("g")
        .attr("transform", function(d,i){
            return "translate(" + (width / 2) + "," + (height / 2) + ")";
        });

    piedata.forEach(function(d,i){
        d._endAngle=d.endAngle;//保存这个值，后面动画要用到。
        d.endAngle=d.startAngle;//让每个弧的弧度都是0
        d.duration=2750*(d.data/d3.sum(solve));   //动画时长2秒，计算每个弧形需要的动画时间
        d.delaytime=sum;
        sum+=d.duration;
    });

    var color = ["#ccffcc","#ffffaa","#abcdef"];

    arcs.append("path")     //给每个分组元素g添加一个路径
        .attr("fill", function(d, i) {
            return color[i];
        })
        .attr("d", function(d, i) {
            return arc(d);
        })
        .style("opacity",0.85)
        .transition()
        .duration(function(d,i){
            return d.duration;
        })
        .ease("bounce")
        .delay(function(d,i){
            return d.delaytime;
        })
        .attrTween("d",tweenArc(function (d,i) {
            return{
                startAngle : d.startAngle,
                endAngle: d._endAngle
            }
        }));
    d3.selectAll("path").attr("transform",function(d){
        var midAngle=(d.startAngle+d.endAngle)/2;
        return "translate("+(1*Math.sin(midAngle))+","+(-1*Math.cos(midAngle))+")";
    });
    function tweenArc(b){
        return function(a,i){
            var d = b.call(this,a,i),
                i = d3.interpolate(a,d);    //d保存转换之后的信息
            //由d.endAngle= d.startAngle 到 d._endAngle的转换插值
            return function(t){
                return arc(i(t));
            }
        }
    }
    var tooltip = d3.select("body")
        .append("div")
        .attr("class","tooltip")
        .style("opacity",0.0);

    arcs.on("mouseover",function(d,i){
        /*
         鼠标移入时，
         （1）通过 selection.html() 来更改提示框的文字
         （2）通过更改样式 left 和 top 来设定提示框的位置
         （3）设定提示框的透明度为1.0（完全不透明）
         */
        var words = "";
        if(i==0) words = "Solve problems: \n"+ d.data;
        if(i==1) words = "Attempting on: \n" + d.data;
        if(i==2) words = "Problems to do: \n"+ d.data;
        tooltip.html(words)
            .style("left", (d3.event.pageX) + "px")
            .style("top", (d3.event.pageY + 20) + "px")
            .style("opacity",1.0);
    })
        .on("mousemove",function(d){
            /* 鼠标移动时，更改样式 left 和 top 来改变提示框的位置 */

            tooltip.style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY + 20) + "px");
        })
        .on("mouseout",function(d){
            /* 鼠标移出时，将透明度设定为0.0（完全透明）*/

            tooltip.style("opacity",0.0);
        });
}
function regenerateA(solved,trying,all){
    d3.select("body").select("div").select("table").select("tr#draw").select("td#A").select("svg").remove("svg");
    d3.select("body").select(".tooltip").remove(".tooltip");
    generateA(solved,trying,all);
}

function generateB(AC,WA,RE,TLE,other) {
    var width= document.getElementById("B").clientWidth,
        height= document.getElementById("B").clientHeight,
        radius = 120;
    //    var data=d3.range(10).map(Math.random).sort(d3.descending);//降序
    var data=[AC,WA,RE,TLE,other];
    var datasum = AC+WA+RE+TLE+other;
    var rate = [AC/datasum,WA/datasum,RE/datasum,TLE/datasum,other/datasum];
    var color2=["#99cc99","#ccffff","#ff6666","#ff9966","#ccccff"];

    var arc=d3.svg.arc().outerRadius(radius);//定义了一个弧生辰器，外半径设置为radius
    var pie=d3.layout.pie().sort(null);                //定义一个饼图布局
    var svg=drawArea.select("td#B").append('svg')
        .attr('width',width)
        .attr('height',height)
        .append('g')
        .attr('transform',"translate("+width/2+","+height/2+")");//添加一个svg,设置宽高，在偏移到中心。
    var arcs=svg.selectAll('g.arc')
        .data(pie(data))            //绑定数据
        .enter().append('g')        //添加g
        .attr('class',"arc");       //定义一个arc类

    arcs.append('path')                 //添加路径
        .attr('fill',function(d,i){     //根据i的下标给每一个元素添加不同的颜色。
            return color2[i];
        })
        .transition()                   //设置动画
        .ease('linear')                 //动画效果
        .duration(2000)                 //持续时间
        .attrTween('d',tweenPie)        //两个属性之间平滑的过渡。
        .transition()
        .ease("elastic")
        .delay(function(d,i){return 2000+i*50}) //设置了一个延迟时间，让每一个内半径不在同一个时间缩小。
        .duration(500)
        .attrTween('d',tweenDonut);

    var tooltip = d3.select("body")
        .append("div")
        .attr("class","tooltip")
        .style("opacity",0.0);

    arcs.on("mouseover",function(d,i){
        var words = "";
        if(i==0) words="Accepted:\n"+(rate[0]*100).toFixed(2)+"%";
        if(i==1) words="Wrong Answer:\n"+(rate[1]*100).toFixed(2)+"%";
        if(i==2) words="Runtime Error:\n"+(rate[2]*100).toFixed(2)+"%";
        if(i==3) words="Time Limit Exceeded:\n"+(rate[3]*100).toFixed(2)+"%";
        if(i==4) words="Other:\n"+(rate[4]*100).toFixed(2)+"%";
        tooltip.html(words)
            .style("left", (d3.event.pageX) + "px")
            .style("top", (d3.event.pageY + 20) + "px")
            .style("opacity",1.0);
        })
        .on("mousemove",function(d){
            tooltip.style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY + 20) + "px");
        })
        .on("mouseout",function(d){
            tooltip.style("opacity",0.0);
        });

    function tweenPie(b){
        //这里将每一个的弧的开始角度和结束角度都设置成了0
        //然后向他们原始的角度(b)开始过渡，完成动画。
        b.innerRadius=0;
        var i=d3.interpolate({startAngle:0,endAngle:0},b);
        //下面的函数就是过渡函数，他是执行多次最终达到想要的状态。
        return function(t){return arc(i(t));};
    }

    function tweenDonut(b){
        //设置内半径不为0
        b.innerRadius=radius*0.6;
        //然后内半径由0开始过渡
        var i=d3.interpolate({innerRadius:0},b);
        return function(t){return arc(i(t));};
    }
}
function regenerateB(AC,WA,RE,TLE,other){
    d3.select("body").select("div").select("table").select("tr#draw").select("td#B").select("svg").remove("svg");
    d3.select("body").select(".tooltip").remove(".tooltip");
    generateB(AC,WA,RE,TLE,other);
}

function generateC(){
    var color = ["#ccffff","#ccccff","#ffcccc","#ffcc99","#ff6666"];
    var width = document.getElementById("C").clientWidth;
    var height = document.getElementById("C").clientHeight;
    var svg = drawArea.select("td#C").append("svg")
        .attr("width",width)
        .attr("height",height);
    var top = (height - 125) / 2;          //中间间距 15
    var left = (width - 295) / 2;          //中间间距 5

    svg.selectAll(".Rect")
        .data(contest)
        .enter()
        .append("rect")
        .attr("class","Rect")
        .attr("y",function (d,i) {
            return top+(i%4)*35;
        })
        .attr("x",function(d,i){
            return left+(parseInt(i/4)*25);
        })
        .style("fill","#ffffff")
        .style("opacity",0)
        .transition()
        .delay(function (d,i) {
            return parseInt(i/4)*120 + Math.random()*50;
        })
        // .duration(1500)
        .style("opacity",1)
        .transition()
        .delay(1500)
        .duration(1250)
        .style("fill",function(d,i){
            if(contest[i]==0) return "#e0e0e0";
            var stage = parseInt(contest[i]/100);
            return color[stage];
        })
;


    var tooltip = d3.select("body")
        .append("div")
        .attr("class","tooltip")
        .style("opacity",0.0);

    svg.selectAll("rect")
        .on("mouseover",function(d,i){
            if(contest[i]==0) return;
            var words = "Contest "+ (i+1) +"\nWeek "+((i%4)+1) +","+month[parseInt(i/4)]+",2017\nScore :"+contest[i];
            tooltip.html(words)
                .style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY + 20) + "px")
                .style("opacity",1.0);
            this.style("cursor","pointer");
        })
        .on("mousemove",function(d){
            if(contest[i]==0) return;
            tooltip.style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY + 20) + "px");
            this.style("cursor","pointer");

        })
        .on("mouseout",function(d){
            tooltip.style("opacity",0.0);
        });
}
function regenerateC() {
    d3.select("body").select("div").select("table").select("tr#draw").select("td#C").select("svg").remove("svg");
    d3.select("body").select(".tooltip").remove(".tooltip");
    generateC();
}

function generateD(){
    var width = document.getElementById("C").clientWidth;
    var height = document.getElementById("C").clientHeight;
    var svg = drawArea.select("td#D").append("svg")
        .attr("width",width)
        .attr("height",height);

    var padding = {left:30, right:30, top:30, bottom:0};


    var xScale = d3.scale.ordinal()
        .domain(d3.range(12))
        .rangeRoundBands([0, width - padding.left - padding.right]);
    var yScale = d3.scale.linear()
        .domain([-20,d3.max(progress)])
        .range([height - padding.top - padding.bottom, 0]);
    var xAxis = d3.svg.axis()
        .scale(xScale)
        .orient("bottom");
    var yAxis = d3.svg.axis()
        .scale(yScale)
        .orient("left");

    //矩形之间的空白
    var rectPadding = 4;

    var rects = svg.selectAll(".MyRect")
        .data(progress)
        .enter()
        .append("rect")
        .attr("class","MyRect")
        .attr("transform","translate(" + padding.left + "," + padding.top + ")")
        .attr("x", function(d,i){
            return xScale(i) + rectPadding/2;
        } )
        .attr("width", xScale.rangeBand() - rectPadding )
        .attr("y",function(d){
            var min = yScale.domain()[0];
            return yScale(min);
        })
        .attr("height", function(d){
            return 0;
        })
        .style("opacity",0)
        .transition()
        .delay(function(d,i){
            return i * 100;
        })
        .duration(1450)
        .ease("bounce")
        .attr("y",function(d){
            return yScale(d);
        })
        .attr("height", function(d){
            return height - padding.top - padding.bottom - yScale(d);
        })
        .style("opacity",function (d,i) {
            if(i==10) return 1;
            return 0.6;
        });

    //添加文字元素
    var texts = svg.selectAll(".MyText")
        .data(progress)
        .enter()
        .append("text")
        .attr("class","MyText")
        .attr("transform","translate(" + padding.left + "," + padding.top + ")")
        .attr("x", function(d,i){
            return xScale(i) + rectPadding/2;
        } )
        .attr("dx",function(){
            return (xScale.rangeBand() - rectPadding)/2;
        })
        .attr("dy",function(d){
            return 10;
        })
        .text(function(d,i){
            return d;
        })
        .attr("y",function(d){
            var min = yScale.domain()[0];
            return yScale(min);
        })
        .transition()
        .delay(function(d,i){
            return i * 100;
        })
        .duration(1450)
        .ease("bounce")
        .attr("y",function(d){
            return yScale(d);
        });

    svg.append("g")
        .attr("class","axis")
        .attr("transform","translate(" + padding.left + "," + (height - padding.bottom) + ")")
        .call(xAxis)
        .style("opacity",0);

    svg.append("g")
        .attr("class","axis")
        .attr("transform","translate(" + padding.left + "," + padding.top + ")")
        .call(yAxis)
        .style("opacity",0);

    var tooltip = d3.select("body")
        .append("div")
        .attr("class","tooltip")
        .style("opacity",0.0);

    svg.selectAll("rect")
        .on("mouseover",function(d,i){
            var words = month[i]+",2017\nEnter Contest:"+contestNum[i]+"\nSolve Problems:"+problemNum[i];
            tooltip.html(words)
                .style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY + 20) + "px")
                .style("opacity",1.0);
            this.style("cursor","pointer");

        })
        .on("mousemove",function(d){
            tooltip.style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY + 20) + "px");
            this.style("cursor","pointer");
        })
        .on("mouseout",function(d){
            tooltip.style("opacity",0.0);
        });
}
function regenerateD() {
    d3.select("body").select("div").select("table").select("tr#draw").select("td#D").select("svg").remove("svg");
    d3.select("body").select(".tooltip").remove(".tooltip");
    generateD();
}

generateA(122,18,450);
generateB(80,77,12,27,15);
generateC();
generateD();

