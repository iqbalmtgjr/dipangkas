<!--begin::Wrapper-->
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <!--begin::Sidebar-->
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <!--begin::Logo-->
        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
            <!--begin::Logo image-->
            <a href="{{ route('home') }}">
                {{-- <h3>SIKU</h3> --}}
                <img alt="Logo" src="assets/media/logos/default-dark.svg" class="h-25px app-sidebar-logo-default" />
                <img alt="Logo" src="assets/media/logos/default-small.svg"
                    class="h-20px app-sidebar-logo-minimize" />
            </a>
            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize">
                <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
            <!--end::Sidebar toggle-->
        </div>
        <!--end::Logo-->
        <!--begin::sidebar menu-->
        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
            <!--begin::Menu wrapper-->
            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                <!--begin::Scroll wrapper-->
                <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                    data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                    data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                    data-kt-scroll-save-state="true">
                    <!--begin::Menu-->
                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                        id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">Menu</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->is('home') || request()->is('dashboard') ? 'active' : '' }}"
                                href="{{ url('home') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-abstract-26 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dashboard</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->is('user-admin') ? 'active' : '' }}"
                                    href="{{ url('user-admin') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-people fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Daftar Pengguna</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->is('mitra-kita') ? 'active' : '' }}"
                                    href="{{ url('mitra-kita') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-briefcase fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Mitra</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endif
                        @if (Auth::user()->role == 'admin_mitra')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->is('user') ? 'active' : '' }}"
                                    href="{{ url('user') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-people fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Pengguna</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->is('kategori') ? 'active' : '' }}"
                                    href="{{ url('kategori') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-notepad fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Kategori</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->is('laporan') ? 'active' : '' }}"
                                    href="{{ url('laporan') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-cheque fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                            <span class="path6"></span>
                                            <span class="path7"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Laporan Keuangan</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        @endif
                        <!--begin:Menu item-->
                        @if (Auth::user()->role == 'admin_mitra' || Auth::user()->role == 'staf_mitra')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->is('pangkas') ? 'active' : '' }}"
                                    href="{{ url('pangkas') }}">
                                    <span class="menu-icon">
                                        <i class="ki-duotone ki-faceid fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                            <span class="path6"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Pangkas Rambut</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        @endif
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Scroll wrapper-->
            </div>
            <!--end::Menu wrapper-->
        </div>
        <!--end::sidebar menu-->
    </div>
    <!--end::Sidebar-->
