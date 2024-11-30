<div>
    <div id="kt_app_toolbar" class="app-toolbar pt-7 pt-lg-10 pb-4">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">
                        Laporan Keuangan
                    </h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-wrap flex-lg-nowrap">
                                    <!--begin::Toolbar-->
                                    <div
                                        class="d-flex flex-column flex-lg-row align-items-center align-items-lg-stretch me-lg-auto mb-5">
                                        <div class="d-flex flex-column flex-lg-row align-items-lg-stretch">
                                            <div class="d-flex align-items-center me-lg-10">
                                                <label class="me-3 text-gray-600 fs-6 fw-bold mb-lg-0">Tanggal
                                                    Awal:</label>
                                                <div class="me-3">
                                                    <div class="d-flex align-items-center">
                                                        <input type="date"
                                                            class="form-control form-control-solid w-100 w-lg-auto"
                                                            wire:model="startDate" placeholder="Pilih Tanggal">
                                                        @error('startDate')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center me-lg-10">
                                                <label class="text-gray-600 fs-6 fw-bold mb-lg-0">Tanggal
                                                    Akhir:</label>
                                                <div class="ms-3">
                                                    <div class="d-flex align-items-center">
                                                        <input type="date"
                                                            class="form-control form-control-solid w-100 w-lg-auto"
                                                            wire:model="endDate">
                                                        @error('endDate')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center align-items-lg-stretch ms-lg-10">
                                            {{-- <div class="d-flex flex-column flex-lg-row"> --}}
                                            <button class="btn btn-primary ms-3" wire:click="filter()">Filter</button>
                                            <button class="btn btn-danger ms-3"
                                                wire:click="resetfilter()">Reset</button>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                {{-- <div class="d-flex">
                                    <h5 class="text-info">Dewasa : {{ $total_dewasa }}</h5>
                                    <div class="ms-auto">
                                        <h5 class="text-info">Anak-anak : {{ $total_anak }}</h5>
                                    </div>
                                    <div class="ms-auto">
                                        <h5 class="text-info">Total : {{ $total_dewasa_anak }}</h5>
                                    </div>
                                </div> --}}
                                <!--begin::Datatable-->
                                <table id="kt_datatable_example_1"
                                    class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th>Tanggal</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($datas as $index => $item)
                                            <tr>
                                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                <td>{{ $item->kategori->kategori }}</td>
                                                <td>{{ 'Rp. ' . number_format($item->total_harga, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="text-white-600 fw-semibold">
                                        <tr>
                                            <th class="text-center" colspan="2">TOTAL</th>
                                            <th>{{ 'Rp. ' . number_format($total, 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                {{ $datas->links('vendor.livewire.bootstrap') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('header')
        <link href="{{ asset('') }}assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
            type="text/css" />
    @endpush

    @push('footer')
        <script src="{{ asset('') }}assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="{{ asset('') }}assets/js/widgets.bundle.js"></script>
        <script src="{{ asset('') }}assets/js/custom/widgets.js"></script>
    @endpush
</div>
