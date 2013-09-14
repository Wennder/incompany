<script>
var chart;
$(document).ready(function() {
   chart = new Highcharts.Chart({
      chart: {
         renderTo: 'comercialHome',
         defaultSeriesType: 'line',
         height:200,
         borderColor:'#FFFFFF'

      },
      title: {
         text: 'Novos Contratos por Mês'
      },
      subtitle: {
         text: ''
      },
      xAxis: {
         categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },
      yAxis: {
         title: {
            text: 'Valores'
         }
      },
      tooltip: {
         enabled: false,
         formatter: function() {
            return '<b>'+ this.series.name +'</b><br/>'+
               this.x +': '+ this.y +'';
         }
      },
      plotOptions: {
         line: {
            dataLabels: {
               enabled: true
            },
            enableMouseTracking: true
         }
      },
      series: [{
         name: 'Valores',
         data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
         }, {
         name: 'Contratos',
         data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
      }]
   });


});
</script>
<div id="comercialHome">

</div>