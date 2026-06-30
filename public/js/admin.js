$(document).ready(function () {
    $("aside li > a").click(function (e) {
        e.preventDefault();
        var $li = $(this).parent();
        var $infoStatus = $li.find('.subtitle').css('display');
        if ($infoStatus == 'block') {
            $li.find('.subtitle').css({ 'display': 'none' });
        } else {
            $li.find('.subtitle').css({ 'display': 'block' });
            $li.siblings('li').find('.subtitle').css({ 'display': 'none' });
        }
    });
    // 统计文章数据并柱形图显示
    $.ajax({
        type: 'POST',
        url: '?p=admin',                        // ? 在 URL 末尾
        contentType: 'application/json',        // 关键：告诉 PHP 这是 JSON
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'  // AJAX 标识
        },
        
        data: JSON.stringify({
            "status": "0",
        }),
        success: function (response) {
            // console.log(response)
            dist = [];
            number = [];
            conData = response.data;
            // console.log(conData)
            // console.log(conData.length)
            i = 0, j = 0;
            for (let subArray of conData) {
                for (let [key, value] of Object.entries(subArray)) { // 注意这里用的是Object.entries(subArray)而不是Object.entries(value)因为subArray已经是对象数组了。
                    if (key == "subject") {
                        dist[i] = value;
                        i++;
                        // console.log(value);
                    }
                    if (key == "count") {
                        number[j] = Number(value);
                        j++;
                        // console.log(value); 
                    }
                }
            }
            // console.log(dist)
            // console.log(number)
            $('#QuantityDisplay').highcharts({

                chart: {
                    type: 'column',
                    // width: 550,
                    // height: 400,

                },
                title: {  // 标题
                    text: '数据数量统计'
                },


                subtitle: {  // 副标题
                    text: 'Source: S_rightContent数据表'
                },

                xAxis: {
                    categories: dist, // X 轴
                    // data: dist , // X 轴
                    // crosshair: true ,
                    // endOnTick: true, // 确保端点对齐刻度线
                    // showLastLabel: true ,// 显示最后一个数据点的标签
                    // axisLabel: {
                    //     interval: 0,
                    //     rotate: 45
                    // },
                    // labels:{
                    //     enabled:true
                    //  } 
                },

                yAxis: { // Y 轴
                    title: {
                        text: '章数 (页)'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },

                tooltip: {
                    valueSuffix: '章'  // 提示信息
                },

                legend: {  // 展示方式
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                accessibility: {
                    enabled: false,
                },

                series: [
                    {
                        name: 'admin',
                        data: number
                    }

                ],
                credits: {
                    enabled: false // 设置为false以隐藏链接
                },
            })
        },
        error: function (xhr, status, error) {
            console.error('AJAX 错误:', error);
        }
    });




});