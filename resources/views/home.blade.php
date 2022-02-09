@extends('layouts.app')

@section('title', 'Home')
@section('description', 'Home Page')

@section('page_level_css')
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.4') }}" rel="stylesheet"
    type="text/css" />
<style>
.d_board_icon {
    display: flex;
    justify-content: center;
    border: 1px solid;
    border-radius: 50%;
    padding: 10px;
}
.d_user{
    color: #F64E60;
}
.d_store{
    color: #f092a5;
}
.d_order{
    color: #f9d877;
    padding-left: 14px;
    padding-right: 14px;
}
.d_product{
    color: #b196c1;
}
.d_system{
    color: #ABDEE6;
}
.d_position{
    display: flex;
    justify-content: center;
}
</style>
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->

    <div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Row-->
								<div class="row">
									<!--begin::Col-->
									<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
										<!--begin::Card-->
										<div class="card card-custom gutter-b card-stretch">
											<!--begin::Body-->
											<div class="card-body pt-4">
												<!--begin::User-->
												<div class="d-flex align-items-end">
													<!--begin::Pic-->
													<div class="d-flex align-items-center">
														<!--begin::Pic-->
														<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
															<div class="symbol symbol-circle symbol-lg-75">
                                                            <i class="fa-3x far fa-user d_user d_board_icon"></i>
															</div>
														</div>
														<!--end::Pic-->
														<!--begin::Title-->
														<div class="d-flex flex-column text-center">
															<h1 class="text-dark font-weight-bold text-hover-primary font-size-h1 mb-0">{{$totalUsers}}</h1>
															<span class="text-muted font-weight-bold font-size-h4">Users</span>
														</div>
														<!--end::Title-->
													</div>
													<!--end::Title-->
												</div>
												<!--end::User-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
										<!--begin::Card-->
										<div class="card card-custom gutter-b card-stretch">
											<!--begin::Body-->
											<div class="card-body pt-4">
												<!--begin::User-->
												<div class="d-flex align-items-end">
													<!--begin::Pic-->
													<div class="d-flex align-items-center">
														<!--begin::Pic-->
														<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
															<div class="symbol symbol-circle symbol-lg-75">
                                                            <i class="fa-3x fas fa-store d_store d_board_icon"></i>
															</div>
														</div>
														<!--end::Pic-->
														<!--begin::Title-->
														<div class="d-flex flex-column text-center">
															<h1 class="text-dark font-weight-bold text-hover-primary font-size-h1 mb-0">{{$totalStores}}</h1>
															<span class="text-muted font-weight-bold font-size-h4">Stores</span>
														</div>
														<!--end::Title-->
													</div>
													<!--end::Title-->
												</div>
												<!--end::User-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Col-->
                                   <!--begin::Col-->
									<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
										<!--begin::Card-->
										<div class="card card-custom gutter-b card-stretch">
											<!--begin::Body-->
											<div class="card-body pt-4">
												<!--begin::User-->
												<div class="d-flex align-items-end">
													<!--begin::Pic-->
													<div class="d-flex align-items-center">
														<!--begin::Pic-->
														<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
															<div class="symbol symbol-circle symbol-lg-75">
                                                            <i class="fa-3x fas fa-box-open d_product d_board_icon"></i>
															</div>
														</div>
														<!--end::Pic-->
														<!--begin::Title-->
														<div class="d-flex flex-column text-center">
															<h1 class="text-dark font-weight-bold text-hover-primary font-size-h1 mb-0">{{$totalProducts}}</h1>
															<span class="text-muted font-weight-bold font-size-h4">Products</span>
														</div>
														<!--end::Title-->
													</div>
													<!--end::Title-->
												</div>
												<!--end::User-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Col-->
									<!--begin::Col-->
									<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
										<!--begin::Card-->
										<div class="card card-custom gutter-b card-stretch">
											<!--begin::Body-->
											<div class="card-body pt-4">
												<!--begin::User-->
												<div class="d-flex align-items-end">
													<!--begin::Pic-->
													<div class="d-flex align-items-center">
														<!--begin::Pic-->
														<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
															<div class="symbol symbol-circle symbol-lg-75">
                                                            <i class="fa-3x far fa-file-alt d_order d_board_icon"></i>
															</div>
														</div>
														<!--end::Pic-->
														<!--begin::Title-->
														<div class="d-flex flex-column text-center">
															<a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h1 mb-0">{{$totalOrders}}</a>
															<span class="text-muted font-weight-bold font-size-h4">Orders</span>
														</div>
														<!--end::Title-->
													</div>
													<!--end::Title-->
												</div>
												<!--end::User-->
											</div> 
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Col-->
								<!--begin::Col-->
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
										<!--begin::Card-->
										<div class="card card-custom gutter-b card-stretch">
											<!--begin::Body-->
											<div class="card-body pt-4">
												<!--begin::User-->
												<div class="d-flex align-items-end">
													<!--begin::Pic-->
													<div class="d-flex align-items-center">
														<!--begin::Pic-->
														<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
															<div class="symbol symbol-circle symbol-lg-75">
                                                            <i class="fa-3x far fa-user d_user d_board_icon"></i>
															</div>
														</div>
														<!--end::Pic-->
														<!--begin::Title-->
														<div class="d-flex flex-column text-center">
															<h1 class="text-dark font-weight-bold text-hover-primary font-size-h1 mb-0">{{$totalCustomers}}</h1>
															<span class="text-muted font-weight-bold font-size-h4">Customers</span>
														</div>
														<!--end::Title-->
													</div>
													<!--end::Title-->
												</div>
												<!--end::User-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Col-->
								</div>
								<!--end::Row-->
								
							</div>
							<!--end::Container-->
						</div>
 <!--  <div class="d-flex flex-column-fluid">
       
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                    <i class="fa-3x far fa-user d_user d_board_icon"></i>
                                </div>
                                <div class="col-lg-8 text-center mt-3">
                                    <h1>{{$totalUsers}}</h1>
                                    <h4 class="text-muted">Users</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                    <i class="fa-3x fas fa-store d_store d_board_icon"></i>
                                </div>
                                <div class="col-lg-8 text-center mt-3">
                                    <h1>{{$totalStores}}</h1>
                                    <h4 class="text-muted">Stores</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                    <i class="fa-3x fas fa-box-open d_product d_board_icon"></i>
                                </div>
                                <div class="col-lg-8 text-center mt-3">
                                    <h1>{{$totalProducts}}</h1>
                                    <h4 class="text-muted">Products</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                    <i class="fa-3x far fa-file-alt d_order d_board_icon"></i>
                                </div>
                                <div class="col-lg-8 text-center mt-3">
                                    <h1>{{$totalOrders}}</h1>
                                    <h4 class="text-muted">Orders</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                    <i class="fa-3x far fa-user d_user d_board_icon"></i>
                                </div>
                                <div class="col-lg-8 text-center mt-3">
                                    <h1>{{$totalCustomers}}</h1>
                                    <h4 class="text-muted">Customers</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
@endsection

@section('page_level_js_plugins')
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.4') }}"></script>
@endsection

@section('page_level_js')
<script src="{{ asset('assets/js/pages/widgets.js?v=7.0.4') }}"></script>
@endsection
