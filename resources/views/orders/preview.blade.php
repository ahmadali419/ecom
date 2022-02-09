@extends('layouts.app')

@section('title', 'Preview Product')
@section('description', 'Preview Product')

@section('page_level_css')


@endsection



@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!-- begin::Card-->
                <div class="card card-custom overflow-hidden">
                    <div class="card-body p-0">
                        <!-- begin: Invoice-->
                        <!-- begin: Invoice header-->
                        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                    <h1 class="display-4 font-weight-boldest mb-10"><span>Order #</span> {{$orderItems->id}}</h1>
                                    <div class="d-flex flex-column align-items-md-end px-0">
                                        <!--begin::Logo-->
                                        <a href="#" class="mb-5">
                                            <img src="assets/media/logos/logo-dark.png" alt="" />
                                        </a>
                                        <!--end::Logo-->
                                        @php
                                            if(isset($orderItems->phone)){
                                                   $phone = str_replace(array( '(', ' ', ')' ), '', $orderItems->phone);

                                                   $phoneNumber =$orderItems->country_short_code.''.$phone;
                                               }else{
                                                   $phone = str_replace(array( '(', ' ', ')' ), '', isset($orderItems->phone));
                                                   $phoneNumber = $phone;
                                               }
                                        @endphp
                                        <span class="d-flex flex-column align-items-md-end opacity-70">
                                            <span>{{$orderItems->name}}</span>
                                            <span>{{$orderItems->email}}</span>
                                            <span>{{$phoneNumber}}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="border-bottom w-100"></div>
                                <div class="d-flex justify-content-between pt-6 pb-10">
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">Country</span>
                                        <span class="opacity-70">{{$orderItems->country}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">State</span>
                                        <span class="opacity-70">{{$orderItems->state}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">City</span>
                                        <span class="opacity-70">{{$orderItems->city}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">Zip Code</span>
                                        <span class="opacity-70">{{$orderItems->zip_code}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">Address</span>
                                        <span class="opacity-70">{{$orderItems->address}}
                                           </span>
                                    </div>
                                </div>
                                <div class="border-bottom w-100"></div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr class="text-center">
                                                <th class="font-weight-bold text-muted text-uppercase">Product Name
                                                </th>
                                                <th class="font-weight-bold text-muted text-uppercase">Quantity</th>
                                                <th class="font-weight-bold text-muted text-uppercase">Scale</th>
                                                <th class="font-weight-bold text-muted text-uppercase">Dimensions
                                                </th>
                                                <th class="font-weight-bold text-muted text-uppercase">Fitting Types
                                                </th>
                                                <th class="font-weight-bold text-muted text-uppercase">Chain Color
                                                </th>
                                                <th class="font-weight-bold text-muted text-uppercase">Side of Controls</th>
                                                <th class="font-weight-bold text-muted text-uppercase">Fitting Option</th>
                                                <th class="font-weight-bold text-muted text-uppercase">Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orderItems->orderdetail as $orderItem)
                                            <tr class="font-weight-bolder">
                                                <td>{{ucfirst($orderItem->orderProducts->name)}}</td>
                                                <td>{{$orderItem->qty}}</td>
                                                <td>{{ucfirst($orderItem->scale)}}</td>
                                                <td>{{$orderItem->dimension}}</td>
                                                <td>{{ucfirst($orderItem->fitting_type)}}</td>
                                                <td>{{ucfirst($orderItem->chain_color)}}</td>
                                                <td>{{ucfirst($orderItem->side_control)}}</td>
                                                <td>{{ucfirst($orderItem->fitting_option)}}</td>
                                                <td>£ {{$orderItem->price}}</td>
                                            </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end: Invoice header-->

                        <!-- begin: Invoice footer-->
                        <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr class="text-center">
                                            <th class="font-weight-bold text-muted text-uppercase">Card NO.</th>
                                            <th class="font-weight-bold text-muted text-uppercase">TOTAL AMOUNT</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="font-weight-bolder">
                                            <td>{{$orderItems->card_number}}</td>
                                            <td class="text-danger font-size-h3 font-weight-boldest">{{$orderItems->total_price}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice footer-->
                        <!-- begin: Invoice action-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-light-primary font-weight-bold"
                                            onclick="window.print();">Download Invoice</button>
                                    <button type="button" class="btn btn-primary font-weight-bold"
                                            onclick="window.print();">Print Invoice</button>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice action-->
                        <!-- end: Invoice-->
                    </div>
                </div>
                <!-- end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>



@endsection
@section('page_level_js_plugins')

@endsection
