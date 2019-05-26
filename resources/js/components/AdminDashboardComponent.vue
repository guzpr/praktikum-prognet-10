<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h2>Chart bulanan</h2>
                <h4>Tahun: {{getYear()}}</h4>
                <ChartComponent v-if="!loading" :chartData="chartdata " :options="options"></ChartComponent>
            </div>
        </div>
        <div class="table-responsive table--no-card m-b-40">
                    <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="report in report" :key="report.id">
                                    <th>
                                        {{month[report.month -1]}}
                                    </th>
                                    <th>
                                        {{report.status}}
                                    </th>
                                    <th>
                                       Rp. {{translateThousand(report.total)}}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
            </div>
    </div>
</template>

<script>
import  ChartComponent from "./ChartComponent";
import { getMonth,getYear } from "date-fns";
export default {
    components:{
        ChartComponent
    },
    data(){
        return {
            chartdata: {
                labels: [],
               
            },
            loading:true,
            report:[],
            labels:[],
            datasets:[],
            options: {
                maintainAspectRatio: false,
                responsive:true,
                tooltips: {
                    mode: 'index',
                    callbacks: {
                        label: function(tooltipItem, data) {
                            console.log()
                            return data.datasets[tooltipItem.datasetIndex].label+": Rp. " + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                                return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                            });
                        }
                    }
                },
                scales: {
                    yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            if(parseInt(value) >= 1000){
                                return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            } else {
                                return 'Rp. ' + value;
                            }
                            }
                        }
                    }]
                }
            },
            month:['January','Feburary','March','April','May','June','July','August','September','October','November','December']
        }
    },
    mounted(){
        axios.get('/api/report/monthly').then(res=>{
            this.report = res.data;
            this.datasets = [...new Set(this.report.map(report=>report.status))]
            this.datasets = this.datasets.map(status=>{
                var backgroundColor;
                var borderColor;
                if(status=='unverified'){
                    backgroundColor = "rgba(255, 159, 64, 0.2)";
                    borderColor = "rgb(255, 159, 64)";
                } else if(status=='pending'){
                    backgroundColor = "rgba(255, 205, 86, 0.2)";
                    borderColor = "rgb(255, 205, 86)";
                } else if(status=='verified'){
                    backgroundColor = "rgba(75, 192, 192, 0.2)";
                    borderColor = "rgb(75, 192, 192)";
                }
                return {label:status,backgroundColor:backgroundColor,borderColor:borderColor}
            });
            this.datasets = this.datasets.map(dataset=>{
                dataset.data = [];
                var data = this.report.map(report=>{
                    if(report.status == dataset.label){
                         dataset.data.push(report.total);
                    }
                })
                return dataset;
            });
            this.chartdata.labels = [...new Set(this.report.map(report=> this.month[report.month-1]))]
            this.chartdata.datasets = this.datasets;
            this.loading = false;
        })
    },
    methods:{
        getYear(){
            return getYear(new Date());
        },
        translateThousand(price){
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
    }
}
</script>

<style>

</style>
