<aside class="fixed w-64 h-screen bg-gradient-to-b from-cyan-400 to-teal-500 text-white">

    <!-- Logo -->
    <div class="p-6 text-center border-b border-white/30">
        <h1 class="text-xl font-bold">
            CRM <br> Listrik Bro
        </h1>
        <p class="text-sm mt-1 capitalize">
            {{ auth()->user()->role }}
        </p>
    </div>

    <!-- Menu -->
    <nav class="p-4 space-y-6">

        <!-- Dashboard (semua role) -->
        <a href="{{ route(auth()->user()->role . '.dashboard') }}"
           class="block bg-white text-cyan-600 py-2 rounded-lg text-center font-semibold">
            Dashboard
        </a>

        <ul class="space-y-2">

            {{-- ================= SUPERADMIN ================= --}}
            @if(auth()->user()->role === 'superadmin')
                <li>
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.0141 18.5002C11.1464 16.1774 12.2135 14 14.5 14C16.7865 14 17.8536 16.1774 17.9859 18.5002C18.0016 18.7759 17.7761 19 17.5 19H11.5C11.2239 19 10.9984 18.7759 11.0141 18.5002Z" fill="#2A4157" fill-opacity="0.24"/>
                                <circle cx="14.5" cy="10.5" r="2.5" fill="#2A4157" fill-opacity="0.24"/>
                                <path d="M5.01399 18.5002C5.17295 15.6757 6.69457 13 10 13C13.3054 13 14.827 15.6757 14.986 18.5002C15.0015 18.7759 14.7761 19 14.5 19H5.5C5.22386 19 4.99848 18.7759 5.01399 18.5002Z" fill="#F7F7F8"/>
                                <circle cx="10" cy="9" r="3" fill="#F7F7F8"/>
                                <path d="M18.5 4.5V8.5M20.5 6.5L16.5 6.5" stroke="#F7F7F8" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <span>Manajemen User</span>
                    </a>
                </li>
            @endif

            {{-- ================= ADMIN ================= --}}
            @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.0141 18.5002C11.1464 16.1774 12.2135 14 14.5 14C16.7865 14 17.8536 16.1774 17.9859 18.5002C18.0016 18.7759 17.7761 19 17.5 19H11.5C11.2239 19 10.9984 18.7759 11.0141 18.5002Z" fill="#2A4157" fill-opacity="0.24"/>
                                <circle cx="14.5" cy="10.5" r="2.5" fill="#2A4157" fill-opacity="0.24"/>
                                <path d="M5.01399 18.5002C5.17295 15.6757 6.69457 13 10 13C13.3054 13 14.827 15.6757 14.986 18.5002C15.0015 18.7759 14.7761 19 14.5 19H5.5C5.22386 19 4.99848 18.7759 5.01399 18.5002Z" fill="#F7F7F8"/>
                                <circle cx="10" cy="9" r="3" fill="#F7F7F8"/>
                                <path d="M18.5 4.5V8.5M20.5 6.5L16.5 6.5" stroke="#F7F7F8" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <span>Manajemen User</span>
                    </a>
                </li>
            @endif

            {{-- ================= SALES ================= --}}
            @if(in_array(auth()->user()->role, ['sales', 'admin']))
            <li>
                    <a href="{{ route('karyawan.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                            <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.0133 2.00668C9.45335 1.58001 8.76002 1.33334 8.00002 1.33334C6.16002 1.33334 4.66669 2.82667 4.66669 4.66667C4.66669 6.50667 6.16002 8 8.00002 8C9.84002 8 11.3334 6.50667 11.3334 4.66667" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.27338 14.6667C2.27338 12.0867 4.84004 10 8.00004 10C8.64004 10 9.26005 10.0867 9.84005 10.2467" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14.6666 12C14.6666 12.2133 14.64 12.42 14.5866 12.62C14.5266 12.8867 14.42 13.1467 14.28 13.3733C13.82 14.1467 12.9733 14.6667 12 14.6667C11.3133 14.6667 10.6933 14.4066 10.2266 13.98C10.0266 13.8066 9.8533 13.6 9.71997 13.3733C9.4733 12.9733 9.33331 12.5 9.33331 12C9.33331 11.28 9.61998 10.62 10.0866 10.14C10.5733 9.64002 11.2533 9.33334 12 9.33334C12.7866 9.33334 13.5 9.67335 13.98 10.22C14.4066 10.6933 14.6666 11.32 14.6666 12Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.9933 11.9867H11.0067" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 11.0133V13.0067" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span>Manajemen Karyawan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                            <svg width="20" height="20" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.5 3H0V13.5C0 14.3325 0.675 15 1.5 15H12V13.5H1.5V3ZM12.375 9.1875C12.375 8.0625 10.125 7.5 9 7.5C7.875 7.5 5.625 8.0625 5.625 9.1875V9.75H12.375V9.1875ZM9 6.1875C9.93 6.1875 10.6875 5.43 10.6875 4.5C10.6875 3.57 9.93 2.8125 9 2.8125C8.07 2.8125 7.3125 3.57 7.3125 4.5C7.3125 5.43 8.07 6.1875 9 6.1875ZM13.5 0H4.5C3.675 0 3 0.675 3 1.5V10.5C3 11.3325 3.675 12 4.5 12H13.5C14.3325 12 15 11.3325 15 10.5V1.5C15 0.6675 14.325 0 13.5 0ZM13.5 10.5H4.5V1.5H13.5V10.5Z" fill="white"/>
                            </svg>
                        </div>
                        <span>Data Customer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('opportunities.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                            <svg width="20" height="20" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.625 19.25H18.375" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.89998 7.3325H3.5C3.01875 7.3325 2.625 7.72625 2.625 8.2075V15.75C2.625 16.2313 3.01875 16.625 3.5 16.625H4.89998C5.38123 16.625 5.77498 16.2313 5.77498 15.75V8.2075C5.77498 7.72625 5.38123 7.3325 4.89998 7.3325Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.2 4.54125H9.79999C9.31874 4.54125 8.92499 4.935 8.92499 5.41625V15.75C8.92499 16.2313 9.31874 16.625 9.79999 16.625H11.2C11.6812 16.625 12.075 16.2313 12.075 15.75V5.41625C12.075 4.935 11.6812 4.54125 11.2 4.54125Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.5 1.75H16.1C15.6188 1.75 15.225 2.14375 15.225 2.625V15.75C15.225 16.2313 15.6188 16.625 16.1 16.625H17.5C17.9813 16.625 18.375 16.2313 18.375 15.75V2.625C18.375 2.14375 17.9813 1.75 17.5 1.75Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span>Opportunity</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('activity.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                            <svg width="20" height="20" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 14.7H11V16.8H4V14.7ZM4 10.5H14V12.6H4V10.5ZM4 6.3H14V8.4H4V6.3ZM16 2.1H11.82C11.4 0.882 10.3 0 9 0C7.7 0 6.6 0.882 6.18 2.1H2C1.86 2.1 1.73 2.1105 1.6 2.142C1.21 2.226 0.86 2.436 0.59 2.7195C0.41 2.9085 0.26 3.1395 0.16 3.3915C0.0600001 3.633 0 3.906 0 4.2V18.9C0 19.1835 0.0600001 19.467 0.16 19.719C0.26 19.971 0.41 20.1915 0.59 20.391C0.86 20.6745 1.21 20.8845 1.6 20.9685C1.73 20.9895 1.86 21 2 21H16C17.1 21 18 20.055 18 18.9V4.2C18 3.045 17.1 2.1 16 2.1ZM9 1.8375C9.41 1.8375 9.75 2.1945 9.75 2.625C9.75 3.0555 9.41 3.4125 9 3.4125C8.59 3.4125 8.25 3.0555 8.25 2.625C8.25 2.1945 8.59 1.8375 9 1.8375ZM16 18.9H2V4.2H16V18.9Z" fill="#F7F7F8"/>
                            </svg>
                        </div>
                        <span>Aktivitas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('installation.my') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                            <svg width="20" height="20" viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.0253 6.875H7.33722L9.06783 1.29766C9.23032 0.644531 8.76314 0 8.12534 0H2.2754C1.78791 0 1.37354 0.382422 1.30854 0.89375L0.00855463 11.2062C-0.068632 11.825 0.386363 12.375 0.975419 12.375H5.79755L3.92476 20.7324C3.77851 21.3855 4.24976 22 4.87131 22C5.21256 22 5.53755 21.8109 5.7163 21.4844L12.8662 8.42188C13.244 7.73867 12.7768 6.875 12.0253 6.875Z" fill="white"/>
                            </svg>
                        </div>
                        <span>Instalasi Listrik</span>
                    </a>
                </li>
            @endif

            {{-- ================= TEKNISI ================= --}}
            @if(in_array(auth()->user()->role, ['teknisi']))
                <li>
                    <a href="{{ route('teknisi.report') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/20">
                        <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                            <svg width="20" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 14H12V16H4V14ZM4 10H12V12H4V10ZM10 0H2C0.9 0 0 0.9 0 2V18C0 19.1 0.89 20 1.99 20H14C15.1 20 16 19.1 16 18V6L10 0ZM14 18H2V2H9V7H14V18Z" fill="#F7F7F8"/>
                            </svg>
                        </div>
                        <span>Daftar Instalasi</span>
                    </a>
                </li>
            @endif  
        </ul>
    </nav>
</aside>