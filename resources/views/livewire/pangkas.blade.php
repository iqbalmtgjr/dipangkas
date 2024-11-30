<div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="col-12">
                <div class="row mb-5">
                    <div class="card">
                        <div class="card-body text-center">
                            <h1 class="text-danger">
                                {{ isset(auth()->user()->mitra) ? auth()->user()->mitra->nama : 'DIPANGKAS' }}
                            </h1>
                            <div class="pt-3">
                                @if ($kategoris->count() == 0)
                                    <h1>(Belum ada kategori)</h1>
                                    <p>Silahkan tambahkan kategori</p>
                                @endif
                                @foreach ($kategoris as $kategori)
                                    <a href="javascript:void(0)" wire:click="pangkas({{ $kategori->id }})"
                                        class="btn btn-{{ ['primary', 'success', 'info', 'warning', 'danger'][$loop->index % 5] }} me-3 m-2">{{ $kategori->kategori }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-12">
                        <div class="card mb-5">
                            <div class="card-body text-center">
                                <a href="javascript:void(0)" wire:click="pangkas(1)"
                                    class="btn btn-primary me-3">DEWASA</a>
                                <a href="javascript:void(0)" wire:click="pangkas(2)"
                                    class="btn btn-warning">Anak-anak</a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-12">
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body py-4">
                                <!--begin::Wrapper-->
                                <!--end::Wrapper-->
                                {{-- <div class="d-flex">
                                    <h5 class="text-info">Dewasa : {{ $total_dewasa }}</h5>
                                    <div class="ms-auto">
                                        <h5 class="text-info">Anak-anak : {{ $total_anak }}</h5>
                                    </div>
                                    <div class="ms-auto">
                                        <h5 class="text-info"><strong>Total : {{ $total_dewasa_anak }}</strong></h5>
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($datas as $index => $item)
                                            <tr>
                                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                <td>{{ $item->kategori->kategori }}</td>
                                                <td>{{ 'Rp. ' . number_format($item->total_harga, 0, ',', '.') }}</td>
                                                <td><a href="javascript:void(0)" wire:click="hapus({{ $item->id }})"
                                                        class="text-danger">
                                                        <i class="ki-duotone ki-trash fs-2 text-danger">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i></a>
                                                </td>
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
                                <!--end::Datatable-->
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

        {{-- <script>
            "use strict";

            // Class definition
            var KTDatatablesServerSide = function() {
                // Shared variables
                var table;
                var dt;

                // Private functions
                var initDatatable = function() {
                    dt = $("#kt_datatable_example_1").DataTable({
                        searchDelay: 500,
                        processing: true,
                        serverSide: true,
                        order: [
                            [1, 'desc']
                        ],
                        stateSave: true,
                        select: {
                            style: 'multi',
                            selector: 'td:first-child input[type="checkbox"]',
                            className: 'row-selected'
                        },
                        ajax: {
                            url: "{{ url('/getpangkas') }}",
                        },
                        columns: [{
                                data: 'id',
                                visible: false
                            },
                            {
                                data: null,
                                render: function(data, type, full, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                data: 'tanggal'
                            },
                            {
                                data: 'kategori'
                            },
                            {
                                data: 'harga'
                            },
                            // {
                            //     data: null
                            // },
                        ],
                        // Add data-filter attribute
                    });

                    table = dt.$;

                    // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                    dt.on('draw', function() {
                        // initToggleToolbar();
                        // toggleToolbars();
                        handleDeleteRows();
                        KTMenu.createInstances();
                    });
                }

                // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                var handleSearchDatatable = function() {
                    const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                    filterSearch.addEventListener('keyup', function(e) {
                        dt.search(e.target.value).draw();
                    });
                }

                // Delete customer
                var handleDeleteRows = () => {
                    // Select all delete buttons
                    const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                    deleteButtons.forEach(d => {
                        // Delete button on click
                        d.addEventListener('click', function(e) {
                            e.preventDefault();

                            // Select parent row
                            const parent = e.target.closest('tr');

                            // Get customer name
                            const customerName = parent.querySelectorAll('td')[1].innerText;
                            let data = $(this).data()
                            let Id = data.id;

                            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "Yakin ingin menghapus kategori " + customerName + "?",
                                icon: "warning",
                                showCancelButton: true,
                                buttonsStyling: false,
                                confirmButtonText: "Ya, hapus!",
                                cancelButtonText: "Tidak, batal",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-danger",
                                    cancelButton: "btn fw-bold btn-active-light-primary"
                                }
                            }).then(function(result) {
                                if (result.value) {
                                    // Simulate delete request -- for demo purpose only
                                    Swal.fire({
                                        text: "Menghapus " + customerName,
                                        icon: "info",
                                        buttonsStyling: false,
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(function() {
                                        Swal.fire({
                                            text: "Data kategori " +
                                                customerName + " terhapus !.",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, mengerti!",
                                            customClass: {
                                                confirmButton: "btn fw-bold btn-primary",
                                            }
                                        }).then(function() {
                                            window.location =
                                                `{{ url('/kategori/hapus/') }}/${Id}`;
                                            dt.draw();
                                        });
                                    });
                                } else if (result.dismiss === 'cancel') {
                                    Swal.fire({
                                        text: "Kategori " + customerName +
                                            " tidak jadi dihapus.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, mengerti!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    });
                                }
                            });
                        })
                    });
                }

                // Reset Filter
                var handleResetForm = () => {
                    // Select reset button
                    const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');

                    // Reset datatable
                    resetButton.addEventListener('click', function() {
                        // Reset payment type
                        filterPayment[0].checked = true;

                        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search('').draw();
                    });
                }

                // Init toggle toolbar
                var initToggleToolbar = function() {
                    // Toggle selected action toolbar
                    // Select all checkboxes
                    const container = document.querySelector('#kt_datatable_example_1');
                    const checkboxes = container.querySelectorAll('[type="checkbox"]');

                    // Select elements
                    // const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

                    // Toggle delete selected toolbar
                    checkboxes.forEach(c => {
                        // Checkbox on click event
                        c.addEventListener('click', function() {
                            setTimeout(function() {
                                toggleToolbars();
                            }, 50);
                        });
                    });

                    // Deleted selected rows
                    // deleteSelected.addEventListener('click', function() {
                    //     // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    //     Swal.fire({
                    //         text: "Are you sure you want to delete selected customers?",
                    //         icon: "warning",
                    //         showCancelButton: true,
                    //         buttonsStyling: false,
                    //         showLoaderOnConfirm: true,
                    //         confirmButtonText: "Yes, delete!",
                    //         cancelButtonText: "No, cancel",
                    //         customClass: {
                    //             confirmButton: "btn fw-bold btn-danger",
                    //             cancelButton: "btn fw-bold btn-active-light-primary"
                    //         },
                    //     }).then(function(result) {
                    //         if (result.value) {
                    //             // Simulate delete request -- for demo purpose only
                    //             Swal.fire({
                    //                 text: "Deleting selected customers",
                    //                 icon: "info",
                    //                 buttonsStyling: false,
                    //                 showConfirmButton: false,
                    //                 timer: 2000
                    //             }).then(function() {
                    //                 Swal.fire({
                    //                     text: "You have deleted all selected customers!.",
                    //                     icon: "success",
                    //                     buttonsStyling: false,
                    //                     confirmButtonText: "Ok, got it!",
                    //                     customClass: {
                    //                         confirmButton: "btn fw-bold btn-primary",
                    //                     }
                    //                 }).then(function() {
                    //                     // delete row data from server and re-draw datatable
                    //                     dt.draw();
                    //                 });

                    //                 // Remove header checked box
                    //                 const headerCheckbox = container.querySelectorAll(
                    //                     '[type="checkbox"]')[0];
                    //                 headerCheckbox.checked = false;
                    //             });
                    //         } else if (result.dismiss === 'cancel') {
                    //             Swal.fire({
                    //                 text: "Selected customers was not deleted.",
                    //                 icon: "error",
                    //                 buttonsStyling: false,
                    //                 confirmButtonText: "Ok, got it!",
                    //                 customClass: {
                    //                     confirmButton: "btn fw-bold btn-primary",
                    //                 }
                    //             });
                    //         }
                    //     });
                    // });
                }

                // Toggle toolbars
                var toggleToolbars = function() {
                    // Define variables
                    const container = document.querySelector('#kt_datatable_example_1');
                    const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
                    const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
                    const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

                    // Select refreshed checkbox DOM elements
                    const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                    // Detect checkboxes state & count
                    let checkedState = false;
                    let count = 0;

                    // Count checked boxes
                    allCheckboxes.forEach(c => {
                        if (c.checked) {
                            checkedState = true;
                            count++;
                        }
                    });

                    // Toggle toolbars
                    if (checkedState) {
                        selectedCount.innerHTML = count;
                        toolbarBase.classList.add('d-none');
                        toolbarSelected.classList.remove('d-none');
                    } else {
                        toolbarBase.classList.remove('d-none');
                        toolbarSelected.classList.add('d-none');
                    }
                }

                // Public methods
                return {
                    init: function() {
                        initDatatable();
                        handleSearchDatatable();
                        // initToggleToolbar();
                        handleDeleteRows();
                        // handleResetForm();
                    }
                }
            }();

            // On document ready
            KTUtil.onDOMContentLoaded(function() {
                KTDatatablesServerSide.init();
            });
        </script> --}}
    @endpush
</div>
