// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
const input15 = document.getElementById("user");
var a = input15.value ;
const input16 = document.getElementById("prov");
var b = input16.value ;
const input17 = document.getElementById("book");
var c = input17.value ;
console.log(a);
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["user", "provider", "booking"],
    datasets: [{
      data: [a, b, c],
      backgroundColor: ['#3cac54', '#eea02c', '#622e07'],
      hoverBackgroundColor: ['#3cac54', '#eea02c', '#622e07'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
