@extends('layouts.admin')
@section('tittle','Analisis')

@section('content')

<div class="container-fluid px-4">
    <div class="row my-5">
        <h3 class="fs-4 mb-3 form-text-logo">Gráfica</h3>
        <canvas id="grafica"></canvas>
    </div>
</div>
<input type="hidden" name="" class="tp" value="{{implode(",",$dataMount)}}">

<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
<script>
const $grafica = document.querySelector("#grafica");
const tp = document.querySelector(".tp");
const dataMount="<?php echo implode(',',$dataMount) ?>".split(',');
const dataMonth="<?php echo implode(',',$dataMonth) ?>".split(',');
const etiquetas = [...dataMonth];
const datosVentas2020 = {
    label: "Ventas por mes",
    data: [...dataMount],
    backgroundColor: 'rgba(54, 162, 235, 0.2)',
    borderColor: 'rgba(54, 162, 235, 1)',
    borderWidth: 1,
};
new Chart($grafica, {
    type: 'line',
    data: {
        labels: etiquetas,
        datasets: [
            datosVentas2020,
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
        },
    }
});
</script>
@endsection
