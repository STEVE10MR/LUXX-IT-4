

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
            .factura {
            table-layout: fixed;
            }

            .fact-info > div > h5 {
            font-weight: bold;
            }

            .factura > thead {
            border-top: solid 3px #000;
            border-bottom: 3px solid #000;
            }

            .factura > thead > tr > th:nth-child(2), .factura > tbod > tr > td:nth-child(2) {
            width: 300px;
            }

            .factura > thead > tr > th:nth-child(n+3) {
            text-align: right;
            }

            .factura > tbody > tr > td:nth-child(n+3) {
            text-align: right;
            }

            .factura > tfoot > tr > th, .factura > tfoot > tr > th:nth-child(n+3) {
            font-size: 24px;
            text-align: right;
            }

            .cond {
            border-top: solid 2px #000;
            }
    </style>
</head>
<body>

    </div><div id="app" class="col-11">

        <div class="row my-3">
        <div class="col-10">
            <h1>Factura Electronica NutriFit Tacna</h1>
            <p>Francisco Paula Vigil 1126, Tacna 23001</p>
        </div>
        </div>
        <hr />
        <div class="row fact-info mt-3">
        <div class="col-3">
            <h5>Facturar a :</h5><p>{{$name}}</p>
        </div>
        <div class="col-3">
            <h5>Enviar a :</h5><p>{{$email}}</p>
        </div>
        <div class="col-3">
            <h5>N° de factura :</h5><p>{{$order_id}}</p>
            <h5>Fecha :</h5><p>{{$date}}</p>
        </div>
        </div>
        <div class="row my-5">
        <table class="table table-borderless factura">
            <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>

                    <td>#</td>
                    <td>{{$product['producto']}}</td>
                    <td>{{$product['quantity']}}</td>
                    <td>S/.{{$product['price']}}</td>

                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Total Factura</th>
                <th></th>
                <th></th>
                <th>S./ {{$total}}</th>
            </tr>
            </tfoot>
        </table>
        </div>
    </div>
</body>
</html>
