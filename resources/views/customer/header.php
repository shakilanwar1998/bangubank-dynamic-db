<!DOCTYPE html>
<html
    class="h-full bg-gray-100"
    lang="en">
<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0" />

    <!-- Tailwindcss CDN -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- AlpineJS CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com" />
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
            'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
            'Helvetica Neue', sans-serif;
        }
    </style>

    <title><?php echo $data['page_title'] ?></title>
</head>
<body class="h-full">
<div class="min-h-full">
    <div class="bg-emerald-600 pb-32">
        <!-- Navigation -->
        <nav
            class="border-b border-emerald-300 border-opacity-25 bg-emerald-600">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex items-center px-2 lg:px-0">
                        <div class="hidden sm:block">
                            <div class="flex space-x-4">
                                <!-- Current: "bg-emerald-700 text-white", Default: "text-white hover:bg-emerald-500 hover:bg-opacity-75" -->
                                <a
                                    href="/dashboard"
                                    class="bg-emerald-700 text-white rounded-md py-2 px-3 text-sm font-medium"
                                    aria-current="page"
                                >Dashboard</a
                                >
                                <a
                                    href="/deposit"
                                    class="text-white hover:bg-emerald-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium"
                                >Deposit</a
                                >
                                <a
                                    href="/withdraw"
                                    class="text-white hover:bg-emerald-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium"
                                >Withdraw</a
                                >
                                <a
                                    href="/transfer"
                                    class="text-white hover:bg-emerald-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium"
                                >Transfer</a
                                >
                            </div>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex gap-2 sm:items-center">
                        <!-- Profile dropdown -->
                        <div
                            class="relative ml-3">
                            <div>
                                <button
                                    type="button"
                                    class="flex rounded-full bg-white text-sm focus:outline-none"
                                    id="user-menu-button"
                                    aria-expanded="false"
                                    aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <span
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100">
                        <span class="font-medium leading-none text-emerald-700"
                        >AS</span
                        >
                      </span>
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <a
                                    href="/logout"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem"
                                    tabindex="-1"
                                    id="user-menu-item-2"
                                >Sign out</a
                                >
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <!-- Mobile menu button -->
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-emerald-100 hover:bg-emerald-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500"
                            aria-controls="mobile-menu"
                            aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg
                                class="block h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                aria-hidden="true">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>

                            <!-- Icon when menu is open -->
                            <svg

                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        <header class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-white">
                    Howdy, <?php echo $data['user']['name']; ?> 👋
                </h1>
            </div>
        </header>
    </div>

    <main class="-mt-32">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg p-2">
                <!-- Current Balance Stat -->
                <dl
                        class="mx-auto grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
                    <div
                            class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-10 sm:px-6 xl:px-8">
                        <dt class="text-sm font-medium leading-6 text-gray-500">
                            Current Balance
                        </dt>
                        <dd
                                class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                            $<?php echo number_format((new \App\Models\Balance())->findOne('user_id',$_SESSION['user_id'])['amount'] ?? 0,2) ?>
                        </dd>
                    </div>
                </dl>

                <hr />