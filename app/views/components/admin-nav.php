<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex">
                <a href="#" class="text-xl font-bold text-indigo-600 hover:text-indigo-800 transition duration-300">
                    <?= e($_ENV['APP_NAME']) ?>
                </a>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                <a href="<?= e('/logout') ?>" class="text-gray-600 hover:text-indigo-600 transition duration-300"><?= e('Logout') ?></a>
            </div>
            <div class="md:hidden flex items-center">
                <button class="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div class="hidden mobile-menu md:hidden">
        <a href="<?= e('/logout') ?>" class="block py-2 px-4 text-gray-600 hover:bg-indigo-50"><?= e('Logout') ?></a>
    </div>
</nav>