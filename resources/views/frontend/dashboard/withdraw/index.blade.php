@extends( 'frontend.dashboard.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Withdraw
@endsection

@section( 'content' )
    <!--=============================
    DASHBOARD START
  ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include( 'frontend.dashboard.layouts.sidebar' )

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">

                        <h3><i class="far fa-user"></i> All Withdrawals</h3>
                        <div class="wsus__dashboard">
                            <div class="row">
                                <div class="col-md-3">
                                    <a class="wsus__dashboard_item orange" href="{{ route('user.orders.index') }}">
                                        <i class="fas fa-store"></i>
                                        <p>Total Sales</p>
                                        <h4 style="color:#ffff">{{
                                            $settings->currency_icon . number_format($totalEarnings, 2) }}</h4>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="wsus__dashboard_item red" href="{{ route('user.orders.index') }}">
                                        <i class="fas fa-wallet"></i>
                                        <p>Current Balance</p>
                                        <h4 style="color:#ffff">{{
                                            $settings->currency_icon . number_format($currentBalance, 2) }}</h4>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="wsus__dashboard_item green" href="{{ route('user.orders.index') }}">
                                        <i class="fas fa-clock"></i>
                                        <p>Pending Amount</p>
                                        <h4 style="color:#ffff">{{
                                            $settings->currency_icon . number_format($pendingAmount, 2) }}</h4>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="wsus__dashboard_item purple" href="{{ route('user.orders.index') }}">
                                        <i class="fas fa-money-bill"></i>
                                        <p>Total Withdraw</p>
                                        <h4 style="color:#ffff">{{
                                            $settings->currency_icon . number_format($totalWithdraw, 2) }}</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="create_button">
                            <a href="{{ route('vendor.withdraw.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Create Request</a>
                        </div>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
      DASHBOARD START
    ==============================-->
@endsection

@push( 'scripts' )
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
