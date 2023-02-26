@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between">
                        <span>{{ __('Warehouses') }}</span>
                        <a href="{{route('product.create')}}">Create Warehouse</a>
                    </div>
                    <div id="warehouseTableData" data-url="{{ route('warehouse.list') }}"></div>

                    <div class="card-body col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="subcategory_id">Subcategory</label>

                                <select name="subcategory_id" id="subcategory_id" class="form-control">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="name">Filter</label>
                                <input id="warehouse-name" type="text" class="form-control">
                            </div>

                            <div class="col-md-3" style="display: flex; justify-content: center;">
                                <div>
                                    <label for="min_price">Min(Tk)</label>
                                    <input id="min_price" min="0" value="0" type="number" class="form-control">
                                </div>
                                <div>
                                    <label for="max_price">Max(Tk)</label>
                                    <input id="max_price" min="0" value="10000" type="number" class="form-control">
                                </div>
                            </div>



                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table width="100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Owner</th>
                                <th>Add Location</th>
                                <th>Action</th>
                            </tr>

                            </thead>
                            <tbody id="warehouses_table">


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $('document').ready(function() {
            renderWarehouseTable()
        });

        let warehouseName = '';

        $('#warehouse-name').on('keyup', function() {
            warehouseName = this.value.length === 0 ? null : this.value;
            renderWarehouseTable();
        });

        function renderWarehouseTable() {
            const warehouseTableData = document.getElementById('warehouseTableData');
            const baseUrl = warehouseTableData.dataset.url;
            const queryParameters = {};

            if (warehouseName) {
                queryParameters.name = warehouseName;
            }

            const url = baseUrl + '?' + $.param(queryParameters);
            $.ajax({
                url: url,
                type: 'GET',
            })
                .done(function (response) {
                    console.log('warehouses', response['data']);
                    insertWarehouseData(response['data']);
                })
                .fail(function (error) {
                    console.log(error);
                });
        }

        function insertWarehouseData(warehouses) {
            console.log(warehouses,'daa')
            let tableBody = '';
            for (let i=0; i < warehouses?.length; i++) {

                tableBody += `
            <tr>
                <td>${warehouses[i].name}</td>
                <td>${warehouses[i].code}</td>
                <td>${warehouses[i].owner}</td>
                <td>
                    <button class="btn btn-success add-location" data-id="${warehouses[i].id}">
                        <a href="{{url('location')}}/${warehouses[i].id}">
                            Add Location
                        </a>
                    </button>
                </td>
                <td><button class="btn btn-success add-location" data-id="${warehouses[i].id}">Add Location</button></td>
            </tr>
        `;
            }
            $('#warehouses_table').html(tableBody);
        }

    </script>
@endsection
