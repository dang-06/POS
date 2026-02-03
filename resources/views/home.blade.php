@extends('layouts.admin')
@section('content-header', __('dashboard.title'))

@section('content')
<div class="container-fluid">
    <!-- Dashboard Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ __('dashboard.Orders_Count') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$orders_count}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{route('orders.index')}}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{ __('dashboard.Income') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{config('settings.currency_symbol')}} {{number_format($income)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{route('orders.index')}}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{ __('dashboard.Income_Today') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{config('settings.currency_symbol')}} {{number_format($income_today)}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{route('orders.index')}}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{ __('dashboard.Customers_Count') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$customers_count}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <a href="{{ route('customers.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Reports Section -->
    <div class="row">
        <!-- Low Stock Products -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>{{ __('Low Stock Product') }}
                    </h6>
                    <span class="badge badge-danger">{{ count($low_stock_products) }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($low_stock_products as $product)
                                <tr class="{{ $product->quantity <= 5 ? 'table-danger' : 'table-warning' }}">
                                    <td>
                                        <div class="product-image-thumb">
                                            <img src="{{ Storage::url($product->image) }}" 
                                                 alt="{{ $product->name }}"
                                                 class="img-fluid rounded"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold">{{ $product->name }}</div>
                                        <small class="text-muted">{{ $product->barcode }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <span class="font-weight-bold">
                                            {{config('settings.currency_symbol')}}{{ $product->price }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $product->quantity <= 5 ? 'danger' : 'warning' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $product->status ? 'success' : 'danger' }}">
                                            {{ $product->status ? __('common.Active') : __('common.Inactive') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                                        <p class="text-muted">{{ __('No low stock products') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Month Hot Products -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-fire mr-2"></i>{{ __('Hot Products') }} ({{ now()->format('F') }})
                    </h6>
                    <span class="badge badge-primary">{{ count($current_month_products) }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Rank') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Stock') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($current_month_products as $index => $product)
                                <tr>
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $index < 3 ? 'danger' : 'secondary' }}">
                                            #{{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <img src="{{ Storage::url($product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="img-fluid rounded"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold">{{ $product->name }}</div>
                                        <small class="text-muted">{{ $product->barcode }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <span class="font-weight-bold">
                                            {{config('settings.currency_symbol')}}{{ $product->price }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $product->quantity > 20 ? 'success' : ($product->quantity > 10 ? 'warning' : 'danger') }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-chart-line fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">{{ __('No hot products this month') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Best Selling Products -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-trophy mr-2"></i>{{ __('Best Selling Products') }}
                    </h6>
                    <span class="badge badge-success">{{ count($best_selling_products) }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Stock') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($best_selling_products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ Storage::url($product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="img-fluid rounded"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold">{{ $product->name }}</div>
                                        <small class="text-muted">{{ $product->barcode }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <span class="font-weight-bold">
                                            {{config('settings.currency_symbol')}}{{ $product->price }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $product->quantity > 20 ? 'success' : ($product->quantity > 10 ? 'warning' : 'danger') }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $product->status ? 'success' : 'danger' }}">
                                            {{ $product->status ? __('common.Active') : __('common.Inactive') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-star fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">{{ __('No best selling products') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Past Months Hot Products -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-calendar-alt mr-2"></i>{{ __('Hot Products of the year') }}
                    </h6>
                    <span class="badge badge-info">{{ count($past_months_products) }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Stock') }}</th>
                                    <th>{{ __('Updated') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($past_months_products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ Storage::url($product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="img-fluid rounded"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold">{{ $product->name }}</div>
                                        <small class="text-muted">{{ $product->barcode }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <span class="font-weight-bold">
                                            {{config('settings.currency_symbol')}}{{ $product->price }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $product->quantity > 20 ? 'success' : ($product->quantity > 10 ? 'warning' : 'danger') }}">
                                            {{ $product->quantity }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <small class="text-muted">{{ $product->updated_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-history fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">{{ __('No past hot products') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.product-image-thumb {
    width: 40px;
    height: 40px;
    border-radius: 4px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}

.border-left-primary {
    border-left: .25rem solid #4e73df!important;
}

.border-left-success {
    border-left: .25rem solid #1cc88a!important;
}

.border-left-info {
    border-left: .25rem solid #36b9cc!important;
}

.border-left-warning {
    border-left: .25rem solid #f6c23e!important;
}

.shadow {
    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
}

.stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    pointer-events: auto;
    content: "";
    background-color: rgba(0,0,0,0);
}
</style>
@endsection