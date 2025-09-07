<nav x-data="{ open: false }" class="bg-white border-b border-green-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-green-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('*.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Menu Khusus Karyawan --}}
                    @if(auth()->user()->isKaryawan())
                        <x-nav-link :href="route('karyawan.overtime.index')" :active="request()->routeIs('karyawan.overtime.*')">
                            {{ __('Lembur') }}
                        </x-nav-link>
                        <x-nav-link :href="route('karyawan.leaves.index')" :active="request()->routeIs('karyawan.leaves.*')">
                            {{ __('Cuti & Izin') }}
                        </x-nav-link>
                    @endif
                    
                    {{-- Menu Khusus Atasan --}}
                    @if(auth()->user()->isAtasan())
                        <x-nav-link :href="route('atasan.overtime.index')" :active="request()->routeIs('atasan.overtime.*')">
                            {{ __('Persetujuan Lembur') }}
                        </x-nav-link>
                        <x-nav-link :href="route('atasan.leaves.index')" :active="request()->routeIs('atasan.leaves.*')">
                            {{ __('Persetujuan Cuti') }}
                        </x-nav-link>
                        <x-nav-link :href="route('laporan.absensi.index')" :active="request()->routeIs('laporan.absensi.*')">
                            {{ __('Laporan Absensi') }}
                        </x-nav-link>
                    @endif

                    {{-- Menu Khusus Admin --}}
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Manajemen User') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                            {{ __('Pengaturan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.qrcode.show')" :active="request()->routeIs('admin.qrcode.*')">
                            {{ __('QR Code Absensi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('laporan.absensi.index')" :active="request()->routeIs('laporan.absensi.*')">
                            {{ __('Laporan Absensi') }}
                        </x-nav-link>
                         <x-nav-link :href="route('admin.payroll.index')" :active="request()->routeIs('admin.payroll.*')">
                            {{ __('Penggajian') }}
                        </x-nav-link>
                         <x-nav-link :href="route('admin.audit-logs.index')" :active="request()->routeIs('admin.audit-logs.*')">
                             {{ __('Audit Log') }}
                         </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-500 bg-white hover:text-green-900 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-green-700 hover:text-green-500 hover:bg-green-100 focus:outline-none focus:bg-green-100 focus:text-green-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('*.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            {{-- Menu Khusus Karyawan (Mobile) --}}
            @if(auth()->user()->isKaryawan())
                <x-responsive-nav-link :href="route('karyawan.overtime.index')" :active="request()->routeIs('karyawan.overtime.*')">
                    {{ __('Lembur') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('karyawan.leaves.index')" :active="request()->routeIs('karyawan.leaves.*')">
                    {{ __('Cuti & Izin') }}
                </x-responsive-nav-link>
            @endif
            
            {{-- Menu Khusus Atasan (Mobile) --}}
            @if(auth()->user()->isAtasan())
                <x-responsive-nav-link :href="route('atasan.overtime.index')" :active="request()->routeIs('atasan.overtime.*')">
                    {{ __('Persetujuan Lembur') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('atasan.leaves.index')" :active="request()->routeIs('atasan.leaves.*')">
                    {{ __('Persetujuan Cuti') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('laporan.absensi.index')" :active="request()->routeIs('laporan.absensi.*')">
                    {{ __('Laporan Absensi') }}
                </x-responsive-nav-link>
            @endif

            {{-- Menu Khusus Admin (Mobile) --}}
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Manajemen User') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                    {{ __('Pengaturan') }}
                </x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('admin.qrcode.show')" :active="request()->routeIs('admin.qrcode.*')">
                    {{ __('QR Code Absensi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('laporan.absensi.index')" :active="request()->routeIs('laporan.absensi.*')">
                    {{ __('Laporan Absensi') }}
                </x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('admin.payroll.index')" :active="request()->routeIs('admin.payroll.*')">
                    {{ __('Penggajian') }}
                </x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('admin.audit-logs.index')" :active="request()->routeIs('admin.audit-logs.*')">
                    {{ __('Audit Log') }}
              </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-green-700">
            <div class="px-4">
                <div class="font-medium text-base text-green-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-green-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
